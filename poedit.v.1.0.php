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
		$podate = $row['podate'];
		$mode = $row['mode'];
		$delterm = $row['dterm'];
		$daymthdel = $row['ddelivery'];
		$dateofdel = $row['dateofdel'];
		$confdate = $row['confdate'];
		$apprdate = $row['approve'];

		$pterm = $row['pterm'];
		$conformeby = $row['conformeby'];
		$alobs_no = $row['alobs'];
		$alobs_amt = $row['alobsamt'];
		$mod_on = $row['modified'];
		$created_on = $row['created'];
		$mod_by = $row['modifiedby'];
		$created_by = $row['createdby'];
		$suppid = $row['supplierid'];
		
		//get supplier's name, tin and address 
		$qrysupp = "SELECT * FROM itrmc_db01.supplier WHERE id = $suppid";
		$mysqla = $conn->query($qrysupp);
		if ($mysqla->num_rows > 0)
		{
			while($rowi = $mysqla->fetch_assoc())
			{
				$suppname = $rowi['name'];
			}	
		}

		//get the items list
		$qrypoitem = "SELECT * FROM itrmc_db01.purchase_order
					left join itrmc_db01.po_poitems on purchase_order.id = po_poitems.po_id
					left join itrmc_db01.po_item on po_poitems.poitem_id = po_item.id
					where purchase_order.id = '$poid' and po_item.status = 'Active' order by po_poitems.poitem_id asc ";
		
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
				$poitemunit[$ctritem]= $rowb['unit'];
				$poitemdesc[$ctritem]= $rowb['itemdesc'];
				$qty[$ctritem]= $rowb['qty'];
				$unitc[$ctritem]= $rowb['unit_cost'];
				$ctritem++;
			}	
		}

		$qry04 = "SELECT * FROM itrmc_db01.purchase_order
				inner join itrmc_db01.porispr on purchase_order.po_number = porispr.po_no
				inner join itrmc_db01.pr on  porispr.pr_id = pr.id
				where purchase_order.id = $poid";
		$mysql04 = $conn->query($qry04);
		if ($mysql04->num_rows > 0)
		{
			while($row04 = $mysql04->fetch_assoc())
			{
					$purpose = $row04['purpose'];
			}     
		}
				

		
		$ctr++;
		
	}
}


//get supplier's list for the dropdown
$qrysupp02 = "SELECT * FROM itrmc_db01.supplier WHERE supplier.supp_status = 'Active' AND supplier.id != $suppid";
$resultsupp02 = $conn->query($qrysupp02);
$supplierlist = array();
$supplierid = array();
$ctrsupp=0;
if ($resultsupp02->num_rows > 0)
{
	while($rowsupp02 = $resultsupp02->fetch_assoc())
	{
		$supplierlist[]= $rowsupp02['name'];
		$supplierid[]= $rowsupp02['id'];
		$ctrsupp++;
	}
}

 //inner join po, agentprof, profile tables
		$qry06 = "SELECT * FROM itrmc_db01.purchase_order
				inner join itrmc_db01.agentprof on purchase_order.conformeby = agentprof.agentprof_id
				inner join itrmc_db01.profile on  agentprof.profileid = profile.id 
				where purchase_order.id = $poid and purchase_order.conformeby = $conformeby ";
		$mysql06 = $conn->query($qry06);
		if ($mysql06->num_rows > 0)
		{
			while($row06 = $mysql06->fetch_assoc())
			{
					$olname = ucfirst_sentence($row06['lname']);
					$ofname = ucfirst_sentence($row06['fname']);
					$omname = ucfirst_sentence($row06['mname']);
					$oagentid = $row06['agentprof_id'];

			}     
		}

//get all agent's list
$qryagent = "SELECT * FROM itrmc_db01.supplier
					left join itrmc_db01.agentprof on supplier.id = agentprof.companyid
					left join itrmc_db01.profile on agentprof.profileid = profile.id
					where profile.status = 'Active' order by profile.lname asc ";
$resultagent = $conn->query($qryagent);
$agentfname = array();
$agentlname = array();
$agentid = array();
$agentcompany = array();
$ctragent=0;
if ($resultagent->num_rows > 0)
{
	while($rowagent = $resultagent->fetch_assoc())
	{
		$agentfname[] = $rowagent['fname'];
		$agentlname[] = $rowagent['lname'];
		$agentid[] = $rowagent['agentprof_id'];
		$agentcompany[] = $rowagent['name'];

		$ctragent++;
	}
}


?>


<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styleeditpo.css" rel="stylesheet" type="text/css" />
			
		
	</head>
<body ng-app="">
<div id="wholepage">		
		<?php
			include 'header.php';
		?>
		<div id="mbody">
			<div id="maincontent_view">
					<div id="submenu">
					</div>
				
				<div id="contnav">
					<div id="nav1"> 
						<h2> <a href="searchpo.php" >Search PO</a> > Edit PO# <strong><?php echo $po_no; ?></strong></h2>
					</div>
					<div id="nav2"> 
						<a href="searchpo.php" title="Go back from prev page" onClick="history.go(-1);"><img src="/images/icons/back.ico" ></a>
					</div>

				</div>
				<div id="editpo" ng-conroller="poeditCtrl">
					
						<?php //process_editpo.php
						echo '
							
							<form name="editpoform" id="editpoform" method="post" action="process_editpo.php" >
							<input type="hidden" name="poid" value="'.$poid.'" />
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
										<strong>San Fernando City</strong>
									</td>
								</tr>
							</table>

							<table>	
								<tr>
									
									<td id="tbl_label">Supplier: </td> 
									<td>
									<select name="supplier" form="editpoform">
									  <option value="'.$suppid.'" selected="selected">'.$suppname.'</option>';
									  
									  for($y=0; $y<$ctrsupp; $y++)
									  {
									  	echo "<option value='".$supplierid[$y]."'>".$supplierlist[$y]."</option>";
									  }
									  
						echo '
									</select>
									</td>

									<td id="tbl_label" >P.O. No.: </td> 
									<td>
										<input type="text" name="po_no" value="'.$po_no.'" readonly>
										
									</td>
								</tr>
								<tr>
									<td id="tbl_label">Address: </td>	<td><i>Auto update</i> </td>
									<td id="tbl_label"> Date: </td>	
									<td><input type="date" name="podate" id="podate" value="'.$podate .'" required /></td>
								</tr>
								<tr>
									<td id="tbl_label" >TIN: </td>	
									<td><i>Auto update</i></td>
									<td id="tbl_label"> Mode of Procurement: </td>	
									<td><input type="text" name="mode" id="mode" value="'.$mode.'" required /></td>
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
									<td>
										<input type="text" name="delterm" id="delterm" value="'.$delterm.'" required />
										<input type="text" name="daymthdel" id="daymthdel"  value="'.$daymthdel.'" readonly>
									</td>
								</tr>
								<tr>
									<td id="tbl_label">Date of Delivery: </td>
									<td><input type="date" name="deldate" id="deldate" value="'.$dateofdel.'" /></td>
									<td id="tbl_label"> Payment Term: </td> 
									<td><input type="text" name="payterm" id="payterm" value="'.$pterm.'" /></td>
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
							<table id="items">';
								

								//print the item desc, unit, qty and unit cost 
								$ctr02 = 1;
								$tamt = 0;
								/*$unit = array();
								$desc = array();*/
								
								for ($i=0; $i < $ctritem; $i++)
								{
									$amt = $qty[$i] * $unitc[$i];
									$tamt = $tamt + $amt;
									//$unitc[$i] = 10000; //test    
									//$unitc[$i] = number_format($unitc[$i], 2, '.', ','); - commented this part para makadisplay ng 1000 or more ang unit cost
									$amt = number_format($amt, 2, '.', ',');
									
									//td id's are "amt" for the text alignment only, this is not an indicator 
									echo '<tr ng-init="qty'.$i.'='.$qty[$i].'; cost'.$i.'='.$unitc[$i].';">';
									echo "
												<td id='amt'>".$ctr02."</td>
												<td> <input type='text' name='unit[".$i."]' value='".$poitemunit[$i]."' required/></td>
												<td colspan='3'><textarea rows='2' name='desc[".$i."]' required>".$poitemdesc[$i]."</textarea></td>";
									echo '
												<td><input type="number" name="qty'.$i.'"  id="qty'.$i.'" min="0" max="10000" ng-model="qty'.$i.'" required /></td>
												<td><input type="number" name="unitcost'.$i.'" ng-model ="cost'.$i.'" step="any" min="0" required /></td>
												<td><input type="text" name="amt'.$i.'" id="amt'.$i.'" step="any" value="{{(qty'.$i.' * cost'.$i.') | currency : \'P \' : 2}}" disabled/></td>

											</tr>';

								$ctr02++;
								}

									echo "
								<input type='hidden' name='no_items' value='".$i."' />
							</table>
							<table>

								<tr><td colspan='1' id='tbl_label'>Purpose : </td><td colspan='7'><textarea rows='4' name='purpose' required>".$purpose."</textarea></td>
								</tr>
							</table>";

						echo "
							<table>";

						echo "			<tr><td colspan='8'>(ORIGINAL Amount in words) ";
										echo numtowords($tamt);
										$tamt = number_format($tamt, 2, '.', ',');
										echo " only. </td>";
						//this is the overall total
						echo '<td><input type="text" name="tamt" id="tamt" value="{{';
							$ctrt = 0;		
							while ($ctrt<$i)
							{
								echo'(qty'.$ctrt.' * cost'.$ctrt++.')';
								if($ctrt<$i){
									echo '+';
								}
								
							}	
							
						echo '| currency : \'Php \' : 2}}" disabled/></td>
								</tr>';
						
						echo "</table> 
						";
						

						echo ' 
							<table id="conforme" >
								<tr><td  colspan="8" ><h4>In case of failure to make the full delivery within the time specified above, a penalty of one-tenth (1-10) of one percent for every day of delay shall be imposed.</h4></td></tr>

								<tr id="conf">
									<td  colspan="5"></td> <td colspan="2" ><h4>Very truly yours,</h4></td>
								</tr>
								
								<tr >
									<td > <h4>Conforme:</h4> </td>
									<td colspan="3" id="line" >
										
										<select name="conforme" form="editpoform">';
									  		echo '<option value="'.$oagentid.'">'.$ofname.' '.$omname.' '.$olname.'</option>';
									  	
										  	for($agent=0; $agent<$ctragent; $agent++)
										  	{
									  			echo '<option value="'.$agentid[$agent].'">'.$agentfname[$agent].' '.$agentlname[$agent].' - '.$agentcompany[$agent] .'</option>';
										  	}
										  

						echo '		
										</select>

									</td>
									<td colspan="1"> </td>
									<td colspan="2" id="line" ></td>
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
									<td colspan="1" id="line"><input type="date" name="confdate" id="confdate" value="'.$confdate.'" required /> </td>
									<td colspan="1"></td>
									<td colspan="1">Date Approved: </td>
									<td colspan="1"><input type="date" name="apprdate" id="apprdate" value="'.$apprdate.'" required /></td>
									<td colspan="1"></td>

								</tr>
							</table>
							
							<table id="funds" >
								<tr  id="fund">
									<td colspan="2"> Funds Available: </td>
									<td colspan="6"></td>	
								</tr>
						';

							
							
							$alobs_amt = number_format($alobs_amt, 2, '.', ',');
							echo '
							<tr>
								<td colspan="1"> </td>
								<td colspan="3" id="line"></td>
								<td colspan="1"></td>
								<td colspan="1" id="tbl_label">ALOBS No.</td>
								<td colspan="2"><input type="text" name="alobs" value="'.$alobs_no.'" required/></td>
							</tr>
							
							<tr>
								<td colspan="1"></td>
								<td colspan="3">Chief Accountant</td>
								<td colspan="1"></td>
								<td colspan="1" id="tbl_label">Amount</td>

								<td colspan="2">
									<input type="text" name="alobsamt" value="'.$alobs_amt.'" required/>
									
								</td>

							</tr>
						</table>
						<table id="amt">
							<tr>
								<td>
									<input type="submit" value="Save"/>
								</td>
							</tr>
						</table>
							';
							?>
					</form>
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