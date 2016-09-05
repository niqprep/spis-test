<?php 
session_start();
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';

//get po details
$qryn = "SELECT pr.id, pr.pr_no, pr.prcat, section.sectname	, pr.prdate, pr.created		
		from pr
			left outer join section on pr.section = section.sect_id
		where sectname <> '' and prcat <> ''
		order by pr.created desc;
		";
$mysqln = $conn->query($qryn);

?>

<html  style="overflow-x: hidden;">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/styletab.css" rel="stylesheet" type="text/css" />
		
	</head>
	<body>
		<table class="tblframe">
		<?php 
			$modc =1;
			if ($mysqln->num_rows > 0)	
			{
			while($rown = $mysqln->fetch_assoc())	
				{
					
					$cat = $rown['prcat']; //pr.id, pr.pr_no, pr.prcat, section.sectname	
					$prid = $rown['id'];
					$prno = $rown['pr_no'];
					$sectname = $rown['sectname'];
					$createddte = $rown['created'];
				
					$prdate = new DateTime($rown['prdate']);
					$prdate = $prdate->format('Y-m-d');
					
					echo '
					<tr ';
					//give id to tr for the row highlight. use modulo
					if ($modc % 2 != 0) 
					{
						echo 'id=trblue';
					}
					
					echo'>
					<td>'.$modc.'. '.$prno.'</td>
					';
					$modc++;
					
					if ($cat == 'HK' OR $cat == 'OS') 
					{
						$qryi = "SELECT stocks.item_name, stocks.`desc` as idesc, stocks.unit
							from pr_items
								left outer join stocks on pr_items.itemid = stocks.id
							 where pr_items.pr_id = $prid
							 order by pr_items.itemid
							 limit 1;";
					}
					else
					{
						$qryi = "SELECT othstocks.item_name, othstocks.`desc` as idesc, othstocks.unit
							from pr_items
								left outer join othstocks on pr_items.itemid = othstocks.id
							 where pr_items.pr_id = $prid
							 order by pr_items.itemid
							 limit 1;";
					}
					
					$mysqli = $conn->query($qryi);
					if ($mysqli->num_rows > 0)	
						{
						while($rowi = $mysqli->fetch_assoc())	
							{
								$itemname = $rowi['item_name'];
								$itemu = $rowi['unit'];
								$itemdesc = $rowi['idesc'];
								
							}
						}	



					echo '
					<td colspan="2">'.$itemname .' '.$itemdesc.' ,'.$itemu.'</td>
					<td colspan="1">'.$sectname.'</td>
					<td>
						PR date:'.$prdate.' 
						<a href="" id="logs" ><br>Created: '.$createddte.' </a> 
					</td>
					<td><a href="pritemschk.php?djm='.$prid.'&niq='.$prno.'" title="Create PO" target="_new"> <img src="images\icons\purorder.png" id="utils" ></a>
						<!--<a href="poedit.php?djm='.$prid.'" title="Edit" target="_new"> <img src="images\icons\edit.png" id="utils" ></a>!-->
						<a href="forwardto.php?djm='.$prid.'" title="Forward to Budget" target="_top"> <img src="images\icons\forward.png" id="utils" ></a>
						<a href="podelete.php?djm='.$prid.'" title="Archive" target="_top"> <img src="images\icons\delete.png" id="utils" ></a>
						
					</td>	
					</tr>';
					

				}
				$modc--;
				echo "<tr>
						<td><br><br><i> ".$modc." item/s retrieved. </i>
						</td>
					 </tr>";
			}	
			
			
		?>
		</table>
	</body>
</html>