<?php

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 	


if(!isset($_POST['std']))
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Oops! I think you are missing something.\\n Please try again.");'; 
	echo 'history.go(-1);';
	echo '</script>';
}
else
{
	include 'database/dbconnect.php';
	$stockid = $_POST['std'];
	$from = $_POST['from'];
	$to = $_POST['to'];
	if($to < $from)
	{
		echo '<script type="text/javascript">'; 
		echo 'alert("Oops! INVALID DATES\\n Please try again.");'; 
		echo 'history.go(-1);';
		echo '</script>';
	}
	else
	{
		//inner join tables need with nonperi
		$qry = "SELECT * FROM itrmc_db01.othstocks 
			INNER JOIN itrmc_db01.nonperi on othstocks.id = nonperi.stockid
			INNER JOIN itrmc_db01.bal_log on nonperi.stockid = bal_log.stockid
			LEFT OUTER JOIN itrmc_db01.ris on bal_log.ris = ris.ris_no
			LEFT OUTER JOIN itrmc_db01.dept on ris.rcvd_by = dept.id
			where othstocks.id = '$stockid' 
			and othstocks.s_status = 'Active'
			
			and (bal_log.dte_credeb between '".$from."' and '".$to."')
			ORDER BY bal_log.createdon";

		$addsub = array();
		$qty =  array();
		$dteaddsub =  array();
		$risno = array();
		$balafter = array();
		$dept =  array();
		$purprice = array();
		
		$ctr = 0;
		$result = $conn-> query($qry);
		if ($result-> num_rows > 0)
		{
			while ($row = $result -> fetch_assoc()) 
			{
				$item = ucwords(strtolower($row['item_name']));
				$desc = $row['desc'];
				$brand = $row['brand'];
				$unit = $row['unit'];
				$bal = $row['bal'];
				$purprice[] = $row['purprice'];

				$addsub[] = $row['addsub'];
				$qty[] = $row['qtyn'];
				$dteaddsub[] = $row['dte_credeb'];
				$risno[] = $row['ris'];
				$balafter[] = $row['balafter'];
				$dept[] = $row['name'];
				$ctr++;
			}
			
		}
		//if there are no records in nonperi, then extract to peri tbl
		else
		{
			$qry = "SELECT * FROM itrmc_db01.othstocks 
				INNER JOIN itrmc_db01.peri on othstocks.id = peri.stockid
				INNER JOIN itrmc_db01.bal_log on peri.stockid = bal_log.stockid
				LEFT OUTER JOIN itrmc_db01.ris on bal_log.ris = ris.ris_no
				LEFT OUTER JOIN itrmc_db01.dept on ris.rcvd_by = dept.id
				where othstocks.id = '$stockid' 
				and othstocks.s_status = 'Active'
				and (bal_log.dte_credeb between '".$from."' and '".$to."')
				ORDER BY bal_log.createdon";

			$addsub = array();
			$qty =  array();
			$dteaddsub =  array();
			$risno = array();
			$balafter = array();
			$dept =  array();
			$purprice = array();
			
			$ctr = 0;
			$result = $conn-> query($qry);
			if ($result-> num_rows > 0)
			{
				while ($row = $result -> fetch_assoc()) 
				{
					
					$item = ucwords(strtolower($row['item_name']));
					$desc = $row['desc'];
					$brand = $row['brand'];
					$unit = $row['unit'];
					$bal = $row['bal'];
					$purprice[] = $row['purprice'];

					$addsub[] = $row['addsub'];
					$qty[] = $row['qtyn'];
					$dteaddsub[] = $row['dte_credeb'];
					$risno[] = $row['ris'];
					$balafter[] = $row['balafter'];
					$dept[] = $row['name'];
					$ctr++;
				}
				
			}
			else
			{
				echo '<script type="text/javascript">'; 
				echo 'alert("Oops! There are no records yet.\\n Please try again.");'; 
				echo 'history.go(-1);';
				echo '</script>';
			}
		}

		
		
		//get po number and invoice number
		$ponum = array();
		$inv = array();
		$qrypo = "SELECT * FROM itrmc_db01.othstocks 
					inner JOIN itrmc_db01.bal_log on othstocks.id = bal_log.stockid
					left outer JOIN itrmc_db01.addbalpo on bal_log.log_id = addbalpo.ballog_id
					left outer JOIN itrmc_db01.invoice on addbalpo.invoice_id = invoice.inv_id
					where othstocks.id = '$stockid'
					and othstocks.s_status = 'Active'
					and (bal_log.dte_credeb between '".$from."' and '".$to."')
					ORDER BY bal_log.createdon;";
		$x = 0;
		$resultpo = $conn-> query($qrypo);
		if ($resultpo-> num_rows > 0 ) 
		{
			while($row1 = $resultpo -> fetch_assoc())
			{
				$ponum[] = $row1['po_no'];
				$inv[] = $row1['invoice'];

				$po = $ponum[$x];
				$qrysupp = "SELECT * from supplier inner join purchase_order on supplier.id = purchase_order.supplierid
					where purchase_order.po_number = '$po'";
				$resultsupp = $conn -> query($qrysupp);
				if ($resultsupp -> num_rows > 0)
				{
					while ($rows = $resultsupp-> fetch_assoc()) 
					{
						$suppname[$x] = ucwords(strtolower($rows['name']));
					}
				}
				else
				{
					$suppname[$x] = "";
				}
				$x++;


			}
		}
		

		echo '
		<!DOCTYPE html>
		<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
			if(isset($item))
			{	
				echo '<title>Stock Card - '.$item.', '.$desc.' </title>';
			}	
				echo '<link href="css/style.css" rel="stylesheet" type="text/css" />
				<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
				<script>
					function printDiv(print) 
					{
					     var printContents = document.getElementById(print).innerHTML;
					     var originalContents = document.body.innerHTML;

					     document.body.innerHTML = printContents;

					     window.print();

					     document.body.innerHTML = originalContents;
					}
				</script>
			</head>
		<body id="mc_rcv">
		<div id="navprnt"> <a href="#?" title="Print" onclick="printDiv(\'mbody2\')"><img src="images\icons\print.png" ></a></div>
			<div id="mbody2">
				<div id="title">
					<h2> STOCK CARD </h2>
					From '.$from.' to '.$to.'
				</div>
				<div id="head1">';
				if(isset($item))
				{	
					echo '<h2>'.$item.', '.$desc.'</h2>';
					echo 'Unit: '.$unit.'</br>
						Stock ID No.: '.$stockid.' </br>
						Balance Available: <strong id="hlt">'.$bal.'</strong>';
				}	
					
				echo '	
				</div>
				

				<table id="bintbl">
					<tr>
						<th> Date </th>
						<th> Reference </th>
						<th> From who received / whom issued </th>
						<th> Received </th>
						<th> Issued </th>
						<th> Balance </th>
					</tr>';
					$q=0;
					for ($i=0; $i < $ctr; $i++)
					{ 
						if(($addsub[0] == 'S') and ($q == '0'))
						{
							
							echo '<tr>
									<td> '.$dteaddsub[$q].'</td>
									<td colspan="2"> Balance Forwarded</td>
									<td> </td>
									<td>  </td>';
							$q = $qty[$q] + $balafter[$q];
							echo '
									<td> '.$q.' </td>
							</tr>';	
							
						}
						elseif (($addsub[0] == 'A') and ($q =='0')) 
						{
							echo '<tr>
									<td> '.$dteaddsub[$q].'</td>
									<td colspan="2"> Balance Forwarded</td>
									<td> </td>
									<td>  </td>';
							$q = $balafter[$q] - $qty[$q];
							echo '
									<td> '.$q++.' </td>
							</tr>';	
						}

						if($addsub[$i] == 'S')
						{
							echo '<tr>
									<td> '.$dteaddsub[$i].'</td>
									<td> '.$risno[$i].' </td>
									<td> '.$dept[$i].' </td> 
									<td>  </td>
									<td> '.$qty[$i].' </td>
									<td> '.$balafter[$i].' </td>
							</tr>';	
						}
						else
						{
							echo '<tr>
									<td> '.$dteaddsub[$i].'</td>
									<td>';
									
										if($ponum[$i] != '')
										{
											echo 'PO#'.$ponum[$i];
										}
										if($inv[$i] != '')
										{
											echo ' Inv#'.$inv[$i];
										}
										
										if ($purprice[$i] != '')
										{
											echo ' @Php'.$purprice[$i];
										}
							
							 echo '</td>
									<td>';
										if($suppname[$i] != '')
										{
											echo ' '.$suppname[$i];
										}
										
									
							  echo '</td>
									<td> <b style="color: green;">'.$qty[$i].'</b>  </td>
									<td>  </td>
									<td> '.$balafter[$i].' </td>
							</tr>';	
						}
									

					}
						
					
					

				echo '
					<tr id="eor">
						<td colspan="6">-- End of Record --</td>
					</tr>
				</table>

			</div>	

		<script src="js/angular.min.js"></script>									
		</body>
		</html> ';
	}
}

?>
