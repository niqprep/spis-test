<?php 
session_start();
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';

//get po details
$qryn = "SELECT purchase_order.category as `cat`, dept.`name` as dept, pr_id, pr.pr_no, pr.section, section.sect_id, sectname, podate, po_number, supplier.`name` as supp, purchase_order.id, purchase_order.confdate, purchase_order.dterm
				
		from purchase_order 
			left outer join supplier on purchase_order.supplierid = supplier.id
			left outer join porispr on purchase_order.po_number = porispr.po_no

			left outer join pr on porispr.pr_id = pr.id
			left outer join section on pr.section = section.sect_id 
            left outer join dept on section.deptid = dept.id
		 where purchase_order.status = 'toSupplier'";
$mysqln = $conn->query($qryn);



/*stocks.item_name, stocks.`desc` as idesc, stocks.unit

	left outer join po_poitems on purchase_order.id = po_poitems.po_id 
	left outer join stocks on po_poitems.poitem_id = stocks.id

	'.$itemname.' '.$itemdesc.', '.$itemu.' 
	*/
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
			$currentdate = date('Y-m-d');
			$modc =1;
			if ($mysqln->num_rows > 0)	
			{
			while($rown = $mysqln->fetch_assoc())	
				{
					/*$poid[] = $rown['id'];
					$pono[] = $rown['po_number'];
					$supp[] = $rown['name'];
					$podate[] = $rown['podate'];
					$sectname[] = $rown['sectname'];
					echo '<tr>
					<td>'.$pono[$ctrn].'</td>
					<td>'.$supp[$ctrn].'</td>
					<td>'.$pono[$ctrn].'</td>
					<td>'.$sectname[$ctrn].'</td>
					<td>'.$podate[$ctrn].'</td>
					<td>test</td>
					</tr>';
					$ctrn++;*/
					$dterm = $rown['dterm'];
					$confdate = $rown['confdate'];
					$cat = $rown['cat'];
					$poid = $rown['id'];
					$pono = $rown['po_number'];
					$supp = $rown['supp'];
					$podate = new DateTime($rown['podate']);
					$podate = $podate->format('Y-m-d');
					//$podate = $rown['podate'];
					$dept = $rown['dept'];
					$sectname = $rown['sectname'];
					/*$itemname = $rown['item_name'];
					$itemdesc = $rown['idesc'];
					$itemu = $rown['unit'];*/




					///////////////////////////////////////////////////////////////////////////////////////////
					//compute if the PO is beyond or within
					//sa may  "Forwarded to supplier" tab ito
					$date1 = strtotime($confdate);
					$date2 = strtotime($currentdate);
					$interval = $date2 - $date1;
					$interval = floor($interval/86400);
					if ($interval <= $dterm)
					{
						$wb = " <label style='color: green;'> <b> ( Within )</b></label>";
					}
					else
					{
						$wb = " <label style='color: red;'> <b> ( Beyond )</b></label>";
					}
					///////////////////////////////////////////////////////////////////////////////////////////
					

					echo '
					<tr ';
					//give id to tr for the row highlight. use modulo
					if ($modc % 2 != 0) 
					{
						echo 'id=trblue';
					}
					

					echo'>
					<td>'.$modc.'. '.$pono.' '.$wb.'</td>
					<td>'.$supp.'</td>';
					$modc++;
					//get first line item
					//$ctrn = 0;
					/*$itemname = array();
					$itemu = array();
					$itemdesc = array();*/
					if ($cat == 'HK' OR $cat == 'OS') 
					{
						$qryi = "SELECT stocks.item_name, stocks.`desc` as idesc, stocks.unit, po_poitems.createddte, po_poitems.tobudgetdte, po_poitems.approveddte, po_poitems.frsuppdte, po_poitems.rcvdapprovdte
							from purchase_order 
								left outer join po_poitems on purchase_order.id = po_poitems.po_id
								left outer join stocks on po_poitems.poitem_id = stocks.id
							 where purchase_order.po_number = '$pono'
							 order by po_poitems.poitem_id
							 limit 1;";
					}
					else
					{
						$qryi = "SELECT othstocks.item_name, othstocks.`desc` as idesc, othstocks.unit, po_poitems.createddte, po_poitems.tobudgetdte, po_poitems.approveddte, po_poitems.frsuppdte, po_poitems.rcvdapprovdte
							from purchase_order 
								left outer join po_poitems on purchase_order.id = po_poitems.po_id
								left outer join othstocks on po_poitems.poitem_id = othstocks.id
							 where purchase_order.po_number = '$pono'
							 order by po_poitems.poitem_id
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
								$createddte = $rowi['createddte'];
								$tobudgetdte = $rowi['tobudgetdte'];
								$approveddte = $rowi['approveddte'];
								$frsuppdte = $rowi['frsuppdte'];
								$rcvdapprovdte = $rowi['rcvdapprovdte'];

							}
						}	

					



					echo '
					<td colspan="2">'.$itemname .' '.$itemdesc.' ,'.$itemu.'</td>
					<td colspan="1">'.$sectname.' - '.$dept.'</td>
					<td>
						PO date:'.$podate.' 
						<a href="" id="logs" ><br>Created: '.$createddte.' </a> <br>
						<a href="" id="logs" >To Budget: '.$tobudgetdte.' </a> <br>
						<a href="" id="logs" >Approved by MCC: '.$approveddte.' </a> <br>
						<a href="" id="logs" >Rcvd Approved PO: '.$rcvdapprovdte.' </a>
						<a href="" id="logs" >Rcvd by Supplier: '.$frsuppdte.' </a> <br>
					</td>
					<td><a href="poview.php?djm='.$poid.'" title="View" target="_new"> <img src="images\icons\view3.png" id="utils" ></a>
						<!--<a href="poedit.php?djm='.$poid.'" title="Edit" target="_new"> <img src="images\icons\edit.png" id="utils" ></a>--!>
						<!--<a href="forwardto.php?djm='.$poid.'&<3=new&mpp='.$pono.'" title="Revert to New PO" target="_top"> <img src="images\icons\rewind.png" id="utils" ></a>!-->
						<a href="podelivery.php?djm='.$poid.'&<3=toMCC&mpp='.$pono.'" title="Receive delivery" target="_top"> <img src="images\icons\delivery.png" id="utils" ></a>
						<a href="podelete.php?djm='.$poid.'&mpp='.$pono.'" title="Archive" target="_top"> <img src="images\icons\delete.png" id="utils" ></a>
						
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