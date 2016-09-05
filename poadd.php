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

if (!isset($_POST['bidsuppid']))
	{
	header ("location: po.php");
	}
else 
	{
		//$logno = $_POST['logno'];
		//$suppid = $_POST['suppid'];
		$bidsuppid = $_POST['bidsuppid']; //00000000000000000042
		$prno = $_POST['prno'];
		$prid = $_POST['prid']; //0000000056
		$cat = $_POST['catid']; //category code of PR
	}
//get date and time
$currentdate = date('Y-m-d');
$currentdatetime = date('Y-m-d H:i:s');
$pono2 = date("ymd-His");


///////////////////////////////check PR items from the contract
$biddte = array_values(mysqli_fetch_array($conn->query("SELECT biddingdte from bidding 
															left outer join bidsupp on bidding.bid_id = bidsupp.bid_id 
															where bidsupp.id =$bidsuppid ")))[0];
$qryitem = "SELECT * FROM pr_items where pr_id = $prid ";

$ctri = 0;
$pritemid = array();
$pritemqty = array();
$biditemqty = array();
$availpoqty = array();
$resultitem = $conn->query($qryitem);
if ($resultitem->num_rows > 0)
{
	while($rowi = $resultitem->fetch_assoc())
	{
		$pritemid[] = $rowi['itemid'];
		$pritemqty[] = $rowi['pr_qty']; //PR qty
		$biditemqty[$ctri] = array_values(mysqli_fetch_array($conn->query("SELECT contractqty from bidsuppitem where biddsupp_id = $bidsuppid and itemid = $pritemid[$ctri]")))[0];
		$pototitemqty[] = array_values(mysqli_fetch_array($conn->query("SELECT sum(poqty) from po_poitems where poitem_id = $pritemid[$ctri]")))[0];
		if ($pototitemqty[$ctri] == '') 
		{
			$poitemqty =0;
		}
		$availpoqty[$ctri] = $biditemqty[$ctri] - $pototitemqty[$ctri];
		if ($pritemqty[$ctri] > $availpoqty[$ctri] ) 
		{
			echo 'bad';
		}

		$ctri++; //total no. of items in the PR


	}
}
$logno = $ctri;






///////////////////////////////get bid details
$qrybid = "SELECT bidding.biddingdte, bidding.description, supplier.name, supplier.address, 
					bidsupp.supp_id, supplier.tin, supplier.agent_id
				FROM bidding left outer join bidsupp on bidding.bid_id = bidsupp.bid_id	
							left outer join supplier on bidsupp.supp_id = supplier.id						 						 
				where bidsupp.id = $bidsuppid ";
$resultbid = $conn->query($qrybid);
if ($resultbid->num_rows > 0)
{
	while ($rowb = $resultbid->fetch_assoc())
	{
		$biddte2 = new DateTime( $rowb['biddingdte']);
		$biddte2 = $biddte2->format('F d, Y');
		$descript = $rowb['description'];
		
		$suppid = $rowb['supp_id'];
		$suppname= $rowb['name'];
		$suppadd= $rowb['address'];
		$tin = $rowb['tin'];
		$agent_id = $rowb['agent_id'];
	}
}






//get all employee's list
/*$qryemp = "SELECT * FROM profile WHERE status = '1' order by lname, fname, mname";
$resultemp = $conn->query($qryemp);

$empid = array();
$empfname = array();
$emplname = array();
$empctr=0;
if ($resultemp->num_rows > 0)
{
	while($rowe = $resultemp->fetch_assoc())
	{
		$emplist[]= $rowe['lname'].", ".$rowe['fname']." ".$rowe['mname'];
		$empid[]= $rowe['id'];
		$empctr++;
	}
}
*/

//get all agent's list
/*$qryagent = "SELECT * FROM supplier
					left join agentprof on supplier.id = agentprof.companyid
					left join profile on agentprof.profileid = profile.id
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


//QUERY FOR SECTIONS
/*$qrysect = "	SELECT * from section left outer join dept on section.deptid = dept.id
				where section.stat = '1'
				order by name asc, sectname asc";
$ressect = $conn->query($qrysect);
$sectid = array();
$deptid = array();
$sectname = array();
$dept = array();
$ctrsect = 0;
if($ressect->num_rows > 0)
{
	while ($rowsec = $ressect->fetch_assoc())
	{
		$sectid[] = $rowsec['sect_id'];
		$deptid[] = $rowsec['deptid'];
		$sectname[] = $rowsec['sectname'];
		$dept[] = $rowsec['name'];
		$ctrsect++;
	}
}*/



//QUERY FOR ITEMS DEPENDING ON SELECTED CATEGORY
if($cat == 'HK' || $cat == 'OS')
{
	$qryitem = "	SELECT * from stocks 
					where stocks.category = '$cat' and stocks.s_status = '1'
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
			$itemname[] = $rowi['item_name'];
			$itemdesc[] = $rowi['desc'];
			$itemu[] = $rowi['unit'];
			$ctritem++;
		}
	}
}
else
{
	$qryitem = "	SELECT * from othstocks 
					where othstocks.category = '$cat' and othstocks.s_status = '1'
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
			$itemname[] = $rowi['item_name'];
			$itemdesc[] = $rowi['desc'];
			$itemu[] = $rowi['unit'];
			$ctritem++;
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
						<h2> <a href="searchpo.php" >Create new Purchase Order</strong></h2>
					</div>
					<div id="nav2"> 
						<a href="searchpo.php" title="Go back from prev page" onClick="history.go(-2);"><img src="images\icons\back.ico" ></a>
					</div>

				</div>
				<div id="editpo" ng-conroller="poeditCtrl">
					
						<?php //process_editpo.php
						echo '
							
							<form name="editpoform" id="editpoform" method="post" action="poadd_proc.php" >
							<input type="hidden" name="poid" value="" />
							<input type="hidden" name="suppid" value="'.$suppid.'" />
							<input type="hidden" name="cat" value="'.$cat.'" />
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
									
									<td id="tbl_label">Supplier: </td> 
									<td>
										'.$suppname.'
										<input type="hidden" name="bidsuppid1" value="'.$bidsuppid.'" />

									</td>

									<td id="tbl_label" >P.O. No.: </td> 
									<td>
										<input type="text" name="po_no" id="po_no" value= "'.$pono2.'" autofocus required />
										
									</td>
								</tr>
								<tr>
									<td id="tbl_label">Address: </td>	
									<td>'.$suppadd.' </td>
									<td id="tbl_label"> Date: </td>	
									<td><input type="date" name="podate" id="podate" value="'.$currentdate.'" required /></td>
								</tr>
								<tr>
									<td id="tbl_label" >TIN: </td>	
									<td>'.$tin.'</td>
									<td id="tbl_label"> Mode of Procurement: </td>	
									<td>Bidding - '.$biddte2.' ['.$descript.']</td>
									<input type="hidden" name="mode" value="Bidding" />
								</tr>
							</table>

							<table>
								<tr>
									<td colspan="4">
										Gentlemen: Please furnish this office the following articles subject to the terms and conditions contained herein.
									</td>
								</tr>
								<tr>
									<td id="tbl_label">Place of Delivery:</td>
									<td> ILOCOS TRAINING & REGIONAL MEDICAL CENTER</td>
									<td id="tbl_label"> Delivery Term: </td> 
									<td>
										<input type="number" name="delterm" id="delterm" value="" required />
										<input type="text" name="daymthdel2" id="daymthdel"  value="Calendar Days" readonly>
										<input type="hidden" name="daymthdel" id="daymthdel"  value="CD" >

									</td>
								</tr>
								<tr>
									<td id="tbl_label">Date of Delivery: </td>
									<td><input type="date" name="deldate" id="deldate" value="" disabled /></td>
									<td id="tbl_label"> Payment Term: </td> 
									<td><input type="text" name="payterm" id="payterm" value="" /></td>
								</tr>
							</table>

							<table>
								<tr>
									<th colspan="1">Stock No.</th>
									<th colspan="1"> Unit </th>
									<th colspan="5">Description</th>
									<th colspan="1">Unit Cost</th>
									<th colspan="1">Quantity</td>
									<th colspan="1">Amount</th>
								</tr>
							</table>
							<table id="items">';
								
								$item = array(); //array for item variable name
								$qty = array(); //array for qty variable name

								//GET THE DATA FROM PO3.PHP
								for ($i=0; $i < $logno ; $i++) { 
									$itemvar = "item".$i;
									$qtyvar = "qty".$i;

									$bsiid[] = $_POST[$itemvar];
									$qty[] = $_POST[$qtyvar];

								}
								/*print_r($bsiid); 
								print_r($qty); */
								$id2 = implode(',', $bsiid);
								$id = join("','",$bsiid);

								if ($cat == "HK" OR $cat == "OS")
								{
									$qryii = "SELECT * from bidsuppitem 
												left outer join stocks on bidsuppitem.itemid = stocks.id
												where bidsuppitem.bsi_id in ('$id') ORDER BY FIELD(bsi_id, ".$id2.")";
									
								}
								else
								{
									$qryii = "SELECT * from bidsuppitem 
												left outer join othstocks on bidsuppitem.itemid = othstocks.id
												where bidsuppitem.bsi_id in ('$id') ORDER BY FIELD(bsi_id, ".$id2.")";

								}
								$uprice = array();
								$item = array();
								$itemid = array();
								$desc = array();
								$brand = array();
								$unit = array();
								$bsi_id = array();
								$ctrii = 0;
								$mysqlii = $conn->query($qryii);
								if ($mysqlii->num_rows > 0)
								{
									$qryno = $mysqlii->num_rows;
									while($rowii = $mysqlii->fetch_assoc())
									{
										$uprice[] = $rowii['uprice'];
										$bsi_id[] = $rowii['bsi_id'];
										$item[] = $rowii['item_name'];
										$itemid[] = $rowii['itemid'];
										$desc[] = $rowii['desc'];
										$brand[] = $rowii['brand'];
										$unit[] = $rowii['unit'];
										$ctrii++;
									}
								}

								

								$tamt = 0;
								$num = 1;
								
								//print the item desc, unit, qty and unit cost 
								
								if ($qryno == $logno) 
								{
									//pag di nadoble ung pagenter ng item////////////////////////////////////////////////////////////////////////////////////////////
									
									for ($i=0; $i < $logno; $i++)
									{
										$amt = $qty[$i] * $uprice[$i];
										$tamt = $tamt + $amt;
										$amt = number_format($amt, 2, '.', ',');
									
										echo '<tr ng-init="qty'.$i.'='.$qty[$i].'; cost'.$i.'='.$uprice[$i].';">';

											echo '	<td >'.$num.'</td>
													<td >'.$unit[$i].'</td>
													<input type="hidden" name="bsi_id'.$i.'" value="'.$bsi_id[$i].'" />
													<input type="hidden" name="itemid'.$i.'" value="'.$itemid[$i].'" />
													<td colspan="3">
														'.$item[$i].' '.$desc[$i].'	</td>
													<td id="amt"><input style="width:70px;" type="number" value="'.$uprice[$i].' " name="unitcost'.$i.'" ng-model ="cost'.$i.'" step="any" min="0"  readonly/>	</td>
													<td><input type="number" name="qty'.$i.'" value="'.$qty[$i].'"   id="qty'.$i.'" min="0" ng-model="qty'.$i.'" required /></td>';
									
													echo'<td><input  style="width:70px;"  type="text" name="amt'.$i.'" id="amt'.$i.'" step="any" value="{{(qty'.$i.' * cost'.$i.')| currency : \'P \' : 2 }}" disabled/>	</td>';

										echo '</tr>';
										$num++;
									}

								}
								else
								{
									//pag may nadoble na enter ng item////////////////////////////////////////////////////////////////////////////////////////////////
									$message = "You have typed a duplicate item, please reenter the quantity. Thank you.";
									echo "<script type='text/javascript'>alert('$message');</script>";
									for ($i=0; $i < $qryno; $i++)
									{
										/*$amt = $org_qty[$i] * $org_unitc[$i];
										$tamt = $tamt + $amt;
										$amt = number_format($amt, 2, '.', ',');*/
										
										echo '<tr ng-init="qty'.$i.'=0; cost'.$i.'='.$uprice[$i].';">';

											echo "
													<td >".$num."</td>
													<td >".$unit[$i]."</td>
													<input type='hidden' name='bsi_id".$i."' value='".$bsi_id[$i]."' />
													<td colspan=3>
														".$item[$i]." ".$desc[$i]."	</td>
													<td id='amt'><input style='width:70px;' type='number' value='".$uprice[$i]."' name='unitcost".$i."' ng-model ='cost".$i."' step='any' min='0'  disabled/>	</td>
													<td id='amt'><input type='number' name='qty".$i."' value=''   id='qty".$i."' min='0' ng-model='qty".$i."' required /></td>
													";
													echo '<td><input style="width:70px;" type="text" name="amt'.$i.'" id="amt'.$i.'" step="any" value="{{(qty'.$i.' * cost'.$i.') | currency : \'P \' : 2}}" disabled/>	</td>';

										echo '</tr>';
										$num++;
									}
								}			

									echo "
								<input type='hidden' name='num_items' value='".$i."' />
							</table>
							<table>

								<tr><td colspan='1' id='tbl_label'>Purpose : </td><td colspan='7'><textarea rows='4' name='purpose' required></textarea></td>
								</tr>
							</table>";

						echo "
							<table>";

						echo "			<tr><td colspan='8'>(Amount in words) ";
										
										$amtword = ucfirst(numtowords($tamt));
										echo '<input type="text" name="wordtxt" value="'.$amtword.' only"/>';
										$tamt = number_format($tamt, 2, '.', ',');
										echo "</td>";
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
							<!--<table id="conforme" >
								<tr><td  colspan="8" ><h4>In case of failure to make the full delivery within the time specified above, a penalty of one-tenth (1-10) of one percent for every day of delay shall be imposed.</h4></td></tr>

								<tr id="conf">
									<td  colspan="5"></td> <td colspan="2" ><h4>Very truly yours,</h4></td>
								</tr>
								
								<tr >
									<td > <h4>Conforme:</h4> </td>
									<td colspan="3" id="line" >
										
										';
									  	/*	Authorized Supplier\'s Representative

									  		echo '<select name="conforme" form="editpoform">
									  				<option value="'.$oagentid.'">'.$ofname.' '.$omname.' '.$olname.'</option>';
									  	
										  	for($agent=0; $agent<$ctragent; $agent++)
										  	{
									  			echo '<option value="'.$agentid[$agent].'">'.$agentfname[$agent].' '.$agentlname[$agent].' - '.$agentcompany[$agent] .'</option>';
										  	}
										  	echo '</select>';*/


						echo '		
										
									</td>
									<td colspan="1"> </td>
									<td colspan="2" id="line" >MANUEL F. QUIRINO, MD, MPA, FPAMS</td>
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
							</table>!-->

							<table id="funds" style="min-width:200px;"  >
							<tr>
								<td colspan="1" ><label for="pr_no">PR No.<strong>*</strong> </label></td>
								<td colspan="3"><input type="text" name="pr_no" id="pr_no" required /></td>

								<td colspan="1"><label for="pr_date">PR Date<strong>*</strong> </label></td>
								<td colspan="2"><input type="date" name="pr_date" id="pr_date" max="'.$currentdate.'" required /></td>

							</tr>
							
							<tr>';
						echo'		
								<td colspan="1"><label for="reqby">Requested by<strong>*</strong> </label></td>
								<td colspan="3">
									<select name="reqby" required>';
										  
										  for($x=0; $x<$empctr; $x++)
										  {
										  	echo "<option value='".$empid[$x]."'>".$emplist[$x]." </option>";
										  }
										
										
						echo'		</select>';

						echo'	</td>';

						echo'	<td colspan="1"><label for="sect">Section / Unit<strong>*</strong></label></td>
								<td colspan="2">	
								
											<select name="section" required>';
												 
												  for($x=0; $x<$ctrsect; $x++)
												  {
												  	echo "<option value='".$sectid[$x]."'>".$dept[$x]." - ".$sectname[$x]." </option>";
												  }
												  
												
						echo'				</select>
								</td>';

				echo'		</tr>


							';

								
				echo'		
							<tr><td colspan="1">PO Remarks  </td>
								<td colspan="5"><textarea rows="4" name="remarks" ></textarea></td>
							</tr>
							<tr>
								<td colspan="1"> </td>
								
								<td colspan="5"><i>(Will not be included in the PO print out)</i></td>
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