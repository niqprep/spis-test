<?php

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "issuance";

$cat = $_GET['cat'];
$qry = "SELECT * FROM itrmc_db01.othstocks 
		where othstocks.s_status = 'Active' and category = '$cat'
		order by othstocks.item_name asc, `desc` asc";

$stockid = array();
$item = array();
$desc = array();
$brand = array();
$unit = array();
$bal = array();
$ctr = 0;
$result = $conn-> query($qry);
if ($result-> num_rows > 0)
{
	while ($row = $result -> fetch_assoc()) 
	{
		$stockid[] = $row['id'];
		$item[] = ucwords(strtolower($row['item_name']));
		$desc[] = $row['desc'];
		$brand[] = ucwords(strtolower($row['brand']));
		$unit[] = $row['unit'];
		

		//get the bal from non peri or peri tbl
		//first check nonperi
		$qrybal = "SELECT * from itrmc_db01.nonperi	where nonperi.stockid = $stockid[$ctr]";
		$resbal = $conn->query($qrybal);
		if ($resbal->num_rows > 0)
		{
			while ($rwbal = $resbal->fetch_assoc()) 
			{
				$bal[] = $rwbal['bal'];
			}
		}
		//if no results found, then check peri tbl
		else
		{
			$qrybal2 = "SELECT * from itrmc_db01.peri where peri.stockid = $stockid[$ctr]";
			$resbal2 = $conn->query($qrybal2);
			if ($resbal2->num_rows > 0) 
			{
				while ($rwbal = $resbal2->fetch_assoc()) 
				{
					$bal[] = $rwbal['bal'];
				}
			}
		}
		$ctr++;

	}
}

?>


<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
		
	</head>

<body >

<?php
echo '<div id="wholepage">
';		

			include 'header.php';

echo '<div id="mbody">
			<div id="submenu">
			</div>
			
				<div id="mc_rcv">
					<h2>STOCK CARD</h2>
					<div id="search">
						 <table id="record">';
							   		echo '<tr> 
									   			<td>
													Stock No.
												</td>
												
												<td colspan="5" id="num">
													Item Description
												</td>
												
												<td colspan="2" id="num">
													Available Stock	
												</td>

										 </tr>
						 </table>';
						echo '				 
						<div class="container2">

							   <table id="record">';
							   		

								   	for ($i=0; $i < $ctr; $i++)
								   	{ 
								   		$no = 1+ $i;	
									   	echo '<tr> 
									   			<td>
													'.$no.'.	
												</td>';
												if($brand[$i] != NULL)
												{
													echo '<td colspan="5" id="num">
														<a href="select.php?std='.$stockid[$i].'&it=1" target="_blank">'.$item[$i].', '.$desc[$i].' ('.$brand[$i].') </a>	
													</td>';
												}	
												else 
												{
													echo '<td colspan="5" id="num">
														<a href="select.php?std='.$stockid[$i].'&it=1" target="_blank">'.$item[$i].', '.$desc[$i].'  </a>	
													</td>';
												}
													
													
												echo '<td colspan="2" id="num">
													'.$bal[$i].' '.$unit[$i].'/s left	
												</td>
											</tr>';
								   		
								   	}	
								   	if ($result-> num_rows < 1)
								   	{
								   		echo "<td colspan='5' id='num'><center> There's no item/s yet in the inventory. <p><a href='selcat.php?cat=".$cat."'>Add Stock</a></p><p><a href='additem.php?cat=".$cat."'>Add Item</a></p></center></td>";
								   	}
						echo'	</table>	
						</div>	
				
					</div>
					
				</div>

			<div class="buttons">

			</div>
	</div>
	';
		
		
			include 'footer.php';
?>

</div>

<script src="js/angular.min.js"></script>									

</body>
</html> 
