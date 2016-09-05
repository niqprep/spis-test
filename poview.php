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

if (!isset($_GET['djm']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: searchpo.php");
	} 
$poid = $_GET['djm'];


$qrypo = "SELECT * FROM purchase_order where id = $poid";
$mysql = $conn->query($qrypo);
$ctr=1;
if ($mysql->num_rows > 0)
{
	while($row = $mysql->fetch_assoc())
	{

		$po_no = $row['po_number'];
		$remarks = $row['remarks'];
		$category = $row['category'];
		$status = $row['status'];

		if ($status == "cancelled") 
			{
				$prevstat = array_values(mysqli_fetch_array($conn->query("SELECT prev_stat from cancelledpo where po_id = '$poid'")))[0];
			}	
		else 
			{
				$prevstat = "";
			}
			

		$alobsno = $row['alobs'];
		$alobstyp = $row['alobstyp'];
		$alobsamt = $row['alobsamt'];
		$alobsdte = $row['alobsdte'];

		$podate = new DateTime($row['podate']);
		$podate = $podate->format('Y-m-d');
		//$podate = $row['podate'];
		$mode = $row['mode'];
		$delterm = $row['dterm'];
		$poamount = $row['poamount'];
		//poamount
		//pdelivery = place of delivery, default to itrmc
		$daymthdel = $row['ddelivery'];
		$dateofdel = $row['dateofdel'];
		$apprdate = $row['approve'];

		$pterm = $row['pterm'];
		$confby = $row['conformeby'];
		$confdate = $row['confdate'];
		
		//$alobs_no = $row['alobs'];
		//$alobs_amt = $row['alobsamt'];
		$mod_on = $row['modified'];
		$created_on = $row['created'];
		$mod_by = $row['modifiedby'];
		$created_by = $row['createdby'];
		$suppid = $row['supplierid'];
		
		//$confdate = $row['confdate'];
		$dterm = $row['dterm'];
		$currentdate = date('Y-m-d');

		//get supplier's name, tin and address 
		$qrysupp = "SELECT * FROM itrmc_db01.supplier WHERE id = $suppid";
		$mysqla = $conn->query($qrysupp);
		if ($mysqla->num_rows > 0)
		{
			while($rowi = $mysqla->fetch_assoc())
			{
				$suppname = $rowi['name'];
				$suppadd = $rowi['address'];
				$supptin = $rowi['tin'];
			}	
		}

		//get the items list
		if ($category == 'HK' OR $category == 'OS') 
		{
			$qrypoitem = "SELECT * FROM purchase_order
						left outer join po_poitems on purchase_order.id = po_poitems.po_id
						left outer join stocks on po_poitems.poitem_id = stocks.id
					where purchase_order.id = '$poid' order by po_poitems.poitem_id asc ";
		}
		else
		{
			$qrypoitem = "SELECT * FROM purchase_order
						left outer join po_poitems on purchase_order.id = po_poitems.po_id
						left outer join othstocks on po_poitems.poitem_id = othstocks.id
					where purchase_order.id = '$poid' order by po_poitems.poitem_id asc ";
		}
		
		
		$mysqlb = $conn->query($qrypoitem);	
		$poitemdesc=array();	
		$poitemunit=array();
		$qty=array();
		$unitc= array();
		$ctritem=0;
		if ($mysqlb->num_rows > 0)					
		{						
			while($rowb = $mysqlb->fetch_assoc())
			{
				$poitem[$ctritem]= ucfirst_sentence($rowb['item_name']);
				$poitemunit[$ctritem]= $rowb['unit'];
				$poitemdesc[$ctritem]= ucfirst_sentence($rowb['desc']);
				$qty[$ctritem]= $rowb['poqty'];
				$unitc[$ctritem]= $rowb['pounitcost'];
				
				if (is_null($rowb['confdate'])) {
					$confdate = '';
				}
				else
				{
					$confdate = new DateTime($rowb['confdate']);
					$confdate = $confdate->format('Y-m-d');
					
				}
				
				$ctritem++;
				
			}	
		}
		



		$qry04 = "SELECT purpose, purchase_order.status FROM purchase_order
					inner join porispr on purchase_order.po_number = porispr.po_no
					inner join pr on  porispr.pr_id = pr.id
				where purchase_order.id = $poid";
		$mysql04 = $conn->query($qry04);
		if ($mysql04->num_rows > 0)
		{
			while($row04 = $mysql04->fetch_assoc())
			{
					$purpose = ucfirst_sentence($row04['purpose']);
					$statpo = ucfirst_sentence($row04['status']);
			}     
		}

		//if there's no conforme yet for po except for po with toSupplier status, set name of supplier to blank to prevent error
		if (($status == "toSupplier") or ($prevstat == "toSupplier"))
		{
			//inner join po, agentprof, profile tables
			$qry06 = "SELECT * FROM purchase_order
						left outer join agentprof on  purchase_order.conformeby = agentprof.agentprof_id
						left outer join profile on  agentprof.profileid = profile.id 
						where purchase_order.id = '$poid' and 
							agentprof.agentprof_id = '$confby'";
			$mysql06 = $conn->query($qry06);
			if ($mysql06->num_rows > 0)
			{
				while($row06 = $mysql06->fetch_assoc())
				{
						$lname = ucfirst_sentence($row06['lname']);
						$fname = ucfirst_sentence($row06['fname']);
						$mname = ucfirst_sentence($row06['mname']);
				}     
			}
			///////////////////////////////////////////////////////////////////////////////////////////
			//compute if the PO is beyond or within
			//sa may  "Forwarded to supplier" tab ito
			$date1 = strtotime($confdate);
			$date2 = strtotime($currentdate);
			$interval = $date2 - $date1;
			$interval = floor($interval/86400);
			if ($interval <= $dterm)
			{
				$wb = "(<label style='color: green;'>Within</label>)";
			}
			else
			{
				$wb = "(<label style='color: red;'>Beyond</label>)";
			}
			///////////////////////////////////////////////////////////////////////////////////////////


		}
		else
		{
			$lname = ""; $fname = ""; $mname = ""; $wb = "";
		}

		
	}
}

?>


<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styleviewpo.css" rel="stylesheet" type="text/css" />
			<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>!-->
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
					<div id="nav1"> <h2> <a href="searchpo.php" >Search PO</a> > View PO# <strong><?php echo $po_no; ?></strong></h2>	</div>
					<div id="nav3"> Status: <a href="#" > '.$statpo.'</a> '.$wb.'</div>
					<div id="nav2"> <a href="searchpo.php" title="Go back to prev page" onClick="history.go(-1);"><img src="images\icons\back.ico" ></a></div>';

					if ($statpo == 'New' || $statpo == 'toBudget') 
					{
						echo '<div id="nav2"> <a href="poedit.php?djm='.$poid.'" title="Edit"> <img src="images\icons\edit.png" ></a> </div>';
					}
					
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
									<td id="tbl_label" >P.O. No.: </td> <td><h3>'.$po_no.' </h3></td>
								</tr>
								<tr>
									<td id="tbl_label">Address: </td>	<td>'.$suppadd.' </td>
									<td id="tbl_label"> Date: </td>	<td>'.$podate.'</td>
								</tr>
								<tr>
									<td id="tbl_label" >TIN: </td>	<td>'.$supptin.'</td>
									<td id="tbl_label"> Mode of Procurement: </td>	<td>'.$mode.'</td>
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
									<td id="tbl_label"> Delivery Term: </td> <td>'.$delterm.' '.$daymthdel.'</td>
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
							
							
							/*if (strpos($tamt,".") !== true) {
									$tamt =  $tamt.".00";
								}*/
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
							/*if (strpos($alobs_amt,'.') !== true) {
									$alobs_amt =  $alobs_amt.".00";
								}*/
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
<script src="js/angular.min.js"></script>									

</body>
</html>