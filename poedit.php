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
		$status = $row['status'];
		$po_no = $row['po_number'];
		
		if ($status != 'new')
		{
			echo '<script type="text/javascript">'; 
			echo 'alert("Cannot edit PO# '.$po_no.' because it\'s currently at the Budget Section . \\n Thank you.");'; 
			echo 'window.location.href = "searchpo.php"';
			echo '</script>';

		}
		
		$remarks = $row['remarks'];
		$category = $row['category'];

		$podate = new DateTime($row['podate']);
		$podate = $podate->format('Y-m-d');
		//$podate = $row['podate'];
		$mode = $row['mode'];
		$delterm = $row['dterm'];
		$poamount = $row['poamount'];

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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//QUERY FOR ITEMS DEPENDING ON PO's CATEGORY
if($category == 'HK' || $category == 'OS')
{
	//get the existing items' list
	$org_qrypoitem = "SELECT po_poitems.id as po_poitemsid, stocks.id as stockid, 
						item_name, unit, `desc`, poqty, pounitcost 
					FROM purchase_order
					left outer join po_poitems on purchase_order.id = po_poitems.po_id
					left outer join stocks on po_poitems.poitem_id = stocks.id
				where purchase_order.id = '$poid' order by po_poitems.poitem_id asc";
	
	$org_mysqlb = $conn->query($org_qrypoitem);	
	$org_po_poitemid = array();
	$org_stockid = array();
	$org_poitem = array();
	$org_poitemdesc=array();	
	$org_poitemunit=array();
	$org_qty=array();
	$org_unitc= array();
	$org_ctritem=0;
	if ($org_mysqlb->num_rows > 0)					
	{						
		while($rowb = $org_mysqlb->fetch_assoc())
		{
			$org_po_poitemid[$org_ctritem] = $rowb['po_poitemsid'];
			$org_stockid[$org_ctritem] = $rowb['stockid'];
			$org_poitem[$org_ctritem]= ucfirst_sentence($rowb['item_name']);
			$org_poitemunit[$org_ctritem]= $rowb['unit'];
			$org_poitemdesc[$org_ctritem]= ucfirst_sentence($rowb['desc']);
			$org_qty[$org_ctritem]= $rowb['poqty'];
			$org_unitc[$org_ctritem]= $rowb['pounitcost'];
			$org_ctritem++;
		}	
	}

	//QUERY ALL ITEMS 
	$qryitem = "	SELECT * from stocks 
					where stocks.category = '$category' and stocks.s_status = 'Active'
					order by stocks.item_name asc, stocks.`desc` asc";
	$resitem = $conn->query($qryitem);
	$itemid = array();
	$itemname = array();
	$itemdesc = array();
	$itemu = array();
	$ctritem = 0;
	if($resitem->num_rows > 0)
	{
		while ($rowi = $resitem->fetch_assoc())
		{
			$itemid[] = $rowi['id'];
			$itemname[] = ucfirst_sentence($rowi['item_name']);
			$itemdesc[] = ucfirst_sentence($rowi['desc']);
			$itemu[] = $rowi['unit'];
			$ctritem++;
		}
	}
}
else //if category is not HK / OS
{
	//get the existing items' list
	$org_qrypoitem = "SELECT po_poitems.id as po_poitemsid, othstocks.id as stockid, 
						item_name, unit, `desc`, poqty, pounitcost 
					FROM purchase_order
					left outer join po_poitems on purchase_order.id = po_poitems.po_id
					left outer join othstocks on po_poitems.poitem_id = othstocks.id
				where purchase_order.id = '$poid' order by po_poitems.poitem_id asc";
	
	$org_mysqlb = $conn->query($org_qrypoitem);	
	$org_po_poitemid = array();
	$org_stockid = array();
	$org_poitem = array();
	$org_poitemdesc=array();	
	$org_poitemunit=array();
	$org_qty=array();
	$org_unitc= array();
	$org_ctritem=0;
	if ($org_mysqlb->num_rows > 0)					
	{						
		while($rowb = $org_mysqlb->fetch_assoc())
		{
			$org_po_poitemid[$org_ctritem] = $rowb['po_poitemsid'];
			$org_stockid[$org_ctritem] = $rowb['stockid'];
			$org_poitem[$org_ctritem]= ucfirst_sentence($rowb['item_name']);
			$org_poitemunit[$org_ctritem]= $rowb['unit'];
			$org_poitemdesc[$org_ctritem]= ucfirst_sentence($rowb['desc']);
			$org_qty[$org_ctritem]= $rowb['poqty'];
			$org_unitc[$org_ctritem]= $rowb['pounitcost'];
			$org_ctritem++;
		}	
	}

	//QUERY ALL ITEMS 
	$qryitem = "	SELECT * from othstocks 
					where othstocks.category = '$category' and othstocks.s_status = 'Active'
					order by othstocks.item_name asc, othstocks.`desc` asc";
	$resitem = $conn->query($qryitem);
	$itemid = array();
	$itemname = array();
	$itemdesc = array();
	$itemu = array();
	$ctritem = 0;
	if($resitem->num_rows > 0)
	{
		while ($rowi = $resitem->fetch_assoc())
		{
			$itemid[] = $rowi['id'];
			$itemname[] = ucfirst_sentence($rowi['item_name']);
			$itemdesc[] = ucfirst_sentence($rowi['desc']);
			$itemu[] = $rowi['unit'];
			$ctritem++;
		}
	}
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



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
					$prid = $row04['pr_id'];
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
		$supplierlist[]= ucfirst_sentence($rowsupp02['name']);
		$supplierid[]= $rowsupp02['id'];
		$ctrsupp++;
	}
}

 //inner join po, agentprof, profile tables
/*		$qry06 = "SELECT * FROM purchase_order
					left outer join supplier on purchase_order.supplierid = supplier.id
					left outer join agentprof on supplier.id = agentprof.companyid
					left outer join profile on  agentprof.profileid = profile.id 
				where purchase_order.id = $poid ";
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
}*/


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
						<a href="searchpo.php" title="Go back from prev page" onClick="history.go(-1);"><img src="images\icons\back.ico" ></a>
					</div>

				</div>
				<div id="editpo" ng-conroller="poeditCtrl">
					
						<?php //process_editpo.php
						echo '
							
							<form name="editpoform" id="editpoform" method="post" action="process_editpo.php" >
							<input type="hidden" name="poid" value="'.$poid.'" />
							<input type="hidden" name="prid" value="'.$prid.'" />
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

							<!--<table id="text">
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
							</table>!-->

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
									<td><input type="date" name="deldate" id="deldate" value="'.$dateofdel.'" disabled /></td>
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
								for ($i=0; $i < $org_ctritem; $i++)
								{
									$amt = $org_qty[$i] * $org_unitc[$i];
									$tamt = $tamt + $amt;
									//$org_unitc[$i] = 1000; //test
									//$org_unitc[$i] = number_format($org_unitc[$i], 2, '.', ',');
									$amt = number_format($amt, 2, '.', ',');
									
									//td id's are "amt" for the text alignment only, this is not an indicator 
									echo '<tr ng-init="qty'.$i.'='.$org_qty[$i].'; cost'.$i.'='.$org_unitc[$i].';">';

									//<textarea rows='2' name='desc[".$i."]' required>".$org_poitem[$i]." " .$org_poitemdesc[$i]."</textarea>
									echo "
												<td >".$ctr02."</td>
												<td colspan='4'>
												<input type='hidden' name='po_poitemid".$i."' value='".$org_po_poitemid[$i]."' />
												<select name='items".$i."' required>";

									for($ii = 0; $ii < $ctritem; $ii++)
									{
												//value = stocks.id
												if ($itemid[$ii] == $org_stockid[$i]) {
													echo '<option value="'.$itemid[$ii].'" selected="selected">'.$itemname[$ii].' '.$itemdesc[$ii].', '.$itemu[$ii].' </option> ';
												}
												else
												{
													echo '<option value="'.$itemid[$ii].'">'.$itemname[$ii].' '.$itemdesc[$ii].', '.$itemu[$ii].' </option> ';
												}

									}

									echo "			</select></td>";
									echo '
												<td><input type="number" name="qty'.$i.'"  id="qty'.$i.'" min="0" max="10000" ng-model="qty'.$i.'" required /></td>
												<td id="amt"><input type="number" name="unitcost'.$i.'" ng-model ="cost'.$i.'" step="any" min="0"  required /></td>
												<td id="amt"><input type="text" name="amt'.$i.'" id="amt'.$i.'" step="any" value="{{(qty'.$i.' * cost'.$i.') | currency : \'P \' : 2}}" disabled/></td>

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
										Authorized Supplier\'s Representative
										';
									  	/*	echo '<select name="conforme" form="editpoform">
									  				<option value="'.$oagentid.'">'.$ofname.' '.$omname.' '.$olname.'</option>';
									  	
										  	for($agent=0; $agent<$ctragent; $agent++)
										  	{
									  			echo '<option value="'.$agentid[$agent].'">'.$agentfname[$agent].' '.$agentlname[$agent].' - '.$agentcompany[$agent] .'</option>';
										  	}
										  	echo '</select>';*/


						echo '		
										
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
									<td colspan="1" id="line"><input type="date" name="confdate" id="confdate" value="00/00/0000" disabled/> </td>
									<td colspan="1"></td>
									<td colspan="1">Date Approved: </td>
									<td colspan="1"><input type="date" name="apprdate" id="apprdate" value="00/00/0000"  disabled /></td>
									<td colspan="1"></td>

								</tr>
							</table>

							<table  id="funds" >
							<tr><td colspan="1">PO Remarks : </td><td colspan="7"><textarea rows="4" name="remarks" >'.$remarks.'</textarea></td>
							</tr>
							<tr><td colspan="1"> </td><td colspan="7"><i>(Will not be included in the PO print out)</i></td>
							</tr>
							</table>



							<!--
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
								<td colspan="2"><input type="text" name="alobs" value="'.$alobs_no.'" disabled/></td>
							</tr>
							
							<tr>
								<td colspan="1"></td>
								<td colspan="3">Chief Accountant</td>
								<td colspan="1"></td>
								<td colspan="1" id="tbl_label">Amount</td>

								<td colspan="2">
									<input type="text" name="alobsamt" value="'.$alobs_amt.'" disabled/>
									
								</td>

							</tr>
							</table>!-->

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