<?php
session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 

	
include 'database/dbconnect.php';
include 'functions.php';
$_SESSION['currentpage'] = "po";



$bidsuppid = $_POST['bidsuppid'];
$cntitem = $_POST['cntitem'];
$prid = $_POST['prid'];


$pritemqty = array();
$biditemqty = array();
$pritemid = array();
for ($i=0; $i < $cntitem; $i++)
{
	$pritemqtya = 'pritemqty'.$i;
	$pritemqty[] = $_POST[$pritemqtya];

	$biditemqtya = 'biditemqty'.$i;
	$biditemqty[] = $_POST[$biditemqty];
	
	$pritemida = 'pritemid'.$i;
	$pritemid[] = $_POST[$pritemid];
}

$qrysupp = "SELECT * from supplier left outer join bidsupp on supplier.id = bidsupp.supp_id 
									left outer join bidding on bidsupp.bid_id = bidding.bid_id
						WHERE bidsupp.id = '$bidsuppid'";
$suppinfo = $conn->query($qrysupp);
if ($suppinfo->num_rows > 0)
{
	while($rows = $suppinfo->fetch_assoc())
	{
		$suppname = $rows['name'];
		$suppadd = $rows['address'];
		$supptin = $rows['tin'];
		$biddte2 = new DateTime( $rows['biddingdte']);
		$biddte2 = $biddte2->format('F d, Y');
		$descript = $rows['description'];
	}
}

$pono2 = date("ymd-His");
$currentdate = date('Y-m-d');
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styleviewpo.css" rel="stylesheet" type="text/css" />
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
<body>

<div id="wholepage">		
		<?php
			include 'header.php';
		?>
		<div id="mbody">
			<div id="maincontent_view">
					<div id="submenu">
					</div>
				
				<?php
				echo '
				<div id="contnav">
					<div id="nav1"> <h2> <a href="#" >Search PO</a> > View PO# <strong><?php echo $po_no; ?></strong></h2>	</div>
					<div id="nav3"> Status: <a href="#" > '.$statpo.'</a> '.$wb.'</div>
					<div id="nav2"> <a href="#" title="Go back to prev page" onClick="history.go(-1);"><img src="images\icons\back.ico" ></a></div>';

									
				?>
					<div id="nav2"> <a href="#?" title="Print" onclick="printDiv('print')"><img src="images\icons\print.png" ></a></div>
				</div>
				<div id="print">
							<?php

							echo '
							
					
							<table>
								<tr colspan="8">
									<td colspan="8" id="heading">
										<strong>PURCHASE ORDER</strong>
									</td>
								</tr>
								<tr colspan="8">
									<td colspan="8" id="heading">
										<strong>ILOCOS AND TRAINING REGIONAL MEDICAL CENTER</strong>
									</td>
								</tr>
								<tr colspan="8">
									<td colspan="8" id="heading">
										<strong>Parian, San Fernando City, La Union</strong>
									</td>
								</tr>
							</table>

							<table>	
								<tr>
									<td id="tbl_label">Supplier: </td> <td> '.$suppname.'</td>
									<td id="tbl_label" >P.O. No.: </td> <td><h3>'.$pono2.' </h3></td>
								</tr>
								<tr>
									<td id="tbl_label">Address: </td>	<td>'.$suppadd.' </td>
									<td id="tbl_label"> Date: </td>	
									<td>
										<input type="date" name="podate" id="podate" value="'.$currentdate.'" required />
									</td>
								</tr>
								<tr>
									<td id="tbl_label" >TIN: </td>	<td>'.$supptin.'</td>
									<td id="tbl_label"> Mode of Procurement: </td>	
									<td>Bidding - '.$biddte2.' ['.$descript.']</td>
									<input type="hidden" name="mode" value="Bidding" />
								</tr>
							</table>

							<table id="text">
								<tr>
									<td colspan="8">
										Gentlemen:
									</td>
								</tr>
								<tr>
									<td colspan="8">
										Please furnish this office the following articles subject to the terms and conditions contained herein.
									</td>
								</tr>
							</table>

							<table>
								<tr>
									<td id="tbl_label">Place of Delivery:</td>
									<td> ILOCOS TRAINING & REGIONAL MEDICAL CENTER</td>
									<td id="tbl_label"> Delivery Term: </td> 
									<td><input type="number" name="delterm" id="delterm" value="" required />
										<input type="text" name="daymthdel2" id="daymthdel"  value="Calendar Days" readonly>
										<input type="hidden" name="daymthdel" id="daymthdel"  value="CD" ></td>
								</tr>
								<tr>
									<td id="tbl_label">Date of Delivery: </td>
									<td>'.$dateofdel.'</td>
									<td id="tbl_label"> Payment Term: </td> 
									<td>'.$pterm.'</td>
								</tr>
							</table>

							<table>
								<tr>
									<th colspan="1">Stock No.</th>
									<th colspan="1"> Unit </th>
									<th colspan="5">Description</th>
									<th colspan="1">Quantity</td>
									<th colspan="1">Unit Cost</th>
									<th colspan="1">Amount</th>
								</tr>
							</table>
							<table id="items">
							';

							//print the item desc, unit, qty and unit cost 
							$ctr02 = 1;
							$tamt = 0;
							for ($i=0; $i < $ctritem; $i++)
							{
								$amt = $qty[$i] * $unitc[$i];
								$tamt = $tamt + $amt;
								

								$unitc[$i] = number_format($unitc[$i], 2, '.', ',');
								$amt = number_format($amt, 2, '.', ',');

								echo "<tr>
											<td id='amt'>".$ctr02++."</td>
											<td> ".$poitemunit[$i]." </td>
											<td colspan='3'>".$poitem[$i]." ".$poitemdesc[$i]."</td>
											<td id='amt'>".$qty[$i]."</td>
											<td>P ".$unitc[$i]."</td>";
								
								echo "
											<td >P ".$amt."</td>
									
									 </tr>
							";
							}

							echo "
							</table>
							<table>
								<tr><td colspan='1' id='tbl_label'>Purpose : </td><td colspan='7'>".$purpose."</td>
								</tr>
							</table>";

							echo "
							<table>
								<tr><td colspan='8'>(Amount in words) ";
							echo numtowords($tamt);
							
							
							
							$tamt = number_format($tamt, 2, '.', ',');
							echo " only. </td><td colspan='1' id='tamt'>P ".$tamt."</td></tr>
							</table>";
							?>

						<table id="conforme" >
							<tr><td  colspan="8" ><h4>In case of failure to make the full delivery within the time specified above, a penalty of one-tenth (1/10) of one percent for every day of delay shall be imposed.</h4></td></tr>

							<tr id="conf">
								<td  colspan="5"></td> <td colspan="2" ><h4>Very truly yours,</h4></td>
							</tr>
							<?php 
							if (($status != "toSupplier" ) and ($prevstat != "toSupplier")) 
							{
								$fname = ""; $mname = ""; $lname = "";
							}
							echo 
							'<tr >
								<td > <h4>Conforme:</h4> </td>
								<td colspan="3" id="line" ><strong> '.$fname.' '.$mname.' '.$lname.'</strong></td>
								<td colspan="1"> </td>
								<td colspan="2" id="line" >MANUEL F. QUIRINO, MD, MPA, FPCOM</td>
								<td colspan="1"></td>
							</tr>
							<tr>
								<td> </td>
								<td colspan="3">(Signature over printed name) </td>
								<td colspan="1"></td>
								<td colspan="2">Authorized Official</td>
								<td colspan="1"></td>
							</tr>
							<tr>
							<td> </td><td colspan="3"></td>
							<td colspan="4"></td>
							</tr>
							<tr>
									<td> </td><td colspan="1" id="tbl_label">Date: </td>
									<td colspan="1" id="line"> '.$confdate.'</td>
									<td colspan="1"></td>
									<td colspan="1">Date Approved: </td>
									<td colspan="1">'.$apprdate.'</td>
									<td colspan="1"></td>
							</tr>'
							?>

						</table>

						<table id="funds" >
							<tr  id="fund">
								<td colspan="2"> Funds Available: </td>
								<td colspan="6"></td>
							</tr>
							<?php 
							
							if ($alobsamt > 0) 
							{
								$alobsamt = number_format($alobsamt, 2, '.', ',');
								$alobsamt = 'Php '.$alobsamt.' ('.$alobsdte.')';
							}
							else
							{
								$alobsamt = '';
							}
							
							echo '
							<tr>
								<td colspan="1"> </td>
								<td colspan="3" id="line">Sitti Karen Acosta</td>
								<td colspan="1"></td>
								<td colspan="1" id="tbl_label">ALOBS No.</td>
								<td colspan="2"><strong style="font-size: 14px;">'.$alobstyp.' - '.$alobsno.'</strong></td>
							</tr>

							<tr>
								<td colspan="1"></td>
								<td colspan="3">Chief Accountant</td>
								<td colspan="1"></td>
								<td colspan="1" id="tbl_label">Amount</td>
								<td colspan="2"><strong style="font-size: 14px;"">'.$alobsamt.' </strong></td> 	

							</tr>
							</table>
							';
							?>
					
				</div>
				
			</div>
		</div>
		
		<?php
			include 'footer.php';
		?>

</div>

</body>
</html>
