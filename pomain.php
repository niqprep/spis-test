<?php
session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "po";
/*
if (!isset($_POST['logno']))
	{
	header ("location: po.php");
	}
else 
	{
	$x = 1;
	$logno = $_POST['logno'];
	$cat = $_POST['catid']; //category code

	}*/

//get all employee's list
$qryemp = "SELECT * FROM profile WHERE status = '1' order by lname, fname, mname";
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

//get supplier's list
$qrysupp = "SELECT * FROM supplier WHERE supp_status = '1' order by name";
$resultsupp = $conn->query($qrysupp);
$supplierlist = array();
$supplierid = array();
$ctr=0;
if ($resultsupp->num_rows > 0)
{
	while($row = $resultsupp->fetch_assoc())
	{
		$supplierlist[]= $row['name'];
		$supplierid[]= $row['id'];
		$ctr++;
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

//QUERY DB FOR CATEGORy
$qrycat = "SELECT * from itrmc_db01.cat where catcode = '$cat'";
$resultcat = $conn->query($qrycat);
if ($resultcat->num_rows > 0)
{
	while ($rowcat = $resultcat->fetch_assoc())
	{
		$catid = $rowcat['catid'];
		$catcode = $rowcat["catcode"];
		$catdesc = $rowcat["catdesc"];
		
	}
}

//QUERY FOR SECTIONS
$qrysect = "	SELECT * from itrmc_db01.section left outer join itrmc_db01.dept on section.deptid = dept.id
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
}














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
//get date and time
$currentdate = date('Y-m-d');
$currentdatetime = date('Y-m-d H:i:s');
$pono2 = date("ymd-His");

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
			<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>!-->
	</head>
<body>
<div id="wholepage"">		
		<?php
			include 'header.php';
		?>
		<div id="mbody">
				<div id="submenu">
				</div>
			
			<div id="maincontentpo">
				<h2> LOG PO AND RIS INFORMATION </h2>
				<form id="poform" name="POForm" method="post" action="process_logpo.php" ng-app="" ng-conroller="poCtrl" ng-init="category = 'supplies'">
				<?php echo'<input type="hidden" name="logno" value="'.$logno.'" />';
				?>	
					<div>	
					
						<table id="tablediv" cols="4" >
							
							<?php
								echo '<tr id="subcatdd"> 
									<td id="tdlabel" colspan="2"><i>'.$catdesc.'</i>';
									
									
											//	echo "<option value=".$catcode.">".$catdesc."</option>"; 											
											echo "<input type='hidden' name='cat' value='".$cat."'></td> ";	
							?>
								
							</tr>
								
							<tr>
								<td id="tdlabel"><label for="po_no" >P.O. No.<strong>*</strong></label></td>
								<td><input type="text" name="po_no" id="po_no" value= "<?php echo $pono2; ?>" min="25044" max="35044" autofocus required /></td>
							</tr>
							
							<tr>
								<td id="tdlabel"><label for="date">Date<strong>*</strong></label></td>
								<?php
								echo '<td><input type="date" name="date" id="date" max="'.$currentdate.'"  required /></td>';
								?>
								<td id="tdlabel"><label for="mode">Mode of Procurement<strong>*</strong></label> </td>
								<td><input type="text" name="mode" id="mode" required /></td>
							</tr>

							<!-- $supplierlist[] -->
							<tr id="subcatdd">
								<td id="tdlabel"><label for="supplier"> Supplier<strong>*</strong> </label></td>
								<td colspan="1">
									<select name="supplier" form="poform">
									  <?php 
									  for($x=0; $x<$ctr; $x++)
									  {
									  	echo "<option value='".$supplierid[$x]."'>".$supplierlist[$x]."</option>";
									  }
									  ?>

									</select>
								</td>
							</tr>

						</table>
						
						<table cols="4" id="tablediv">
							<tr>
								<th colspan="4"><i> Please furnish this office the following articles subject to the terms and conditions contained herein.</i></th>
							</tr>
							<tr>
								<td colspan="4"> 
									<label for="placeofdelivery"> Place of Delivery: <strong>ILOCOS TRAINING AND REGIONAL MEDICAL CENTER</strong> </label> 
								</td>
							</tr>
							<tr>
								<td id="tdlabel"><label for="delterm">Delivery Term</label></td>
								<td width="100px"><input type="number" name="delterm" id="delterm" min="1"/></td>
								<td colspan="1" width="100px">
									<input type="text" name="deltermd" value="Calendar Days" readonly="readonly" />

								</td>
								<td> </td>
							</tr>
							
							<tr>
								<td id="tdlabel"><label for="deldate">Delivery date</label></td>
								<td colspan="3" ><input type="text" name="deldate" value="" disabled/></td>
							</tr>
							
							<tr>
								<td id="tdlabel"><label for="payterm">Payment Term</label></td>
								<td colspan="3""><input type="text" name="payterm" id="payterm"/></td>
							</tr>
						</table>
						
						<table id="tabledesc" cols="6" >
							<tr id="thead">
								<td width="5%">Stock No.</td>
								<td>Unit<strong>*</strong></td>
								<td width="40%">Description<strong>*</strong></td>
								<td>Qty<strong>*</strong></td>
								<td>Unit Cost<strong>*</strong></td>
								<td>Total amount</td>
							</tr>
							
							<?php
								$x=1;
								while ($x <= $logno){
									echo '
									<tr ng-init="qty'.$x.'=1; cost'.$x.'=0;">
										<td>'.$x.'</td>
										<td colspan="2"><select name="items'.$x.'" required>';
											for($ii = 0; $ii < $ctritem; $ii++)
											{
												//value = stocks.id
												echo '
													<option value="'.$itemid[$ii].'">'.$itemname[$ii].' '.$itemdesc[$ii].', '.$itemu[$ii].' </option> 
												';
											}
												
										echo'</select>
										</td>										
										
										<td><input type="number" name="qty'.$x.'" id="qty" min="0" max="10000" value="1" ng-model="qty'.$x.'" required /></td>
										<td>Php <input type="number" name="unitcost'.$x.'" id="unitcost" value="0" ng-model ="cost'.$x.'" step="any" min="0" required /></td>
										<td><input type="text" name="amt'.$x.'" id="amt" step="any" value="{{(qty'.$x.' * cost'.$x.') | currency : \'Php \' : 2}}" disabled/></td>
									</tr>
									
									';
									
									$x++;
								}
								$x=1;
								echo '
								<tr id="total">
								<td id="tdlabel" colspan="5"><label for="ttamt"><strong>TOTAL AMOUNT</strong></label></td>
								<td><input type="text" name="ttamt" id="ttamt" value="{{(';
									
									while($x<=$logno){
									echo '(qty'.$x.' * cost'.$x.')';
										if($x<$logno){
										echo '+';
										}
									$x++;
									
									}
									
								echo ')| currency : \'Php \' : 2}}" disabled/></td>
								</tr>
								';

							?>

							

						</table>
						<table id="tablediv" cols="4">
							<tr>
								<td id="tdlabel"><label for="Conforme">Conforme: <strong></strong> </label></td>
								<td colspan="1">
									<input type="text" name="conforme"   disabled />

									  <?php
						echo '
									
								</td>
							</tr>
							<tr>
								<td id="tdlabel"><label for="Conforme">Date of Conforme: <strong></strong> </label></td>
								<td colspan="1"><input name="confdate" type="date" id="confdate" max="'.$currentdate.'" disabled/></td>
							</tr>';

									  ?>
									
							<tr>
								<td id="tdlabel"><label for="approve">Date Approved: <strong></strong> </label></td>
								<td colspan="1"><input type="date" name="approvedate" id="approvedate"  disabled /></td>
							</tr> 
						</table>
						<table  id="tablediv" cols="3" >
							<tr id="thead">
								<td colspan="4"><strong>Requisition and Issue Slip Information / Purchase Request Info</strong></td>
							</tr>
							<tr>
								<td id="tdlabel"><label for="ris_no">RIS No.<strong></strong> </label></td>
								<td colspan="2"><input type="text" name="risno" id="risno"  disabled/></td>
							</tr>
							<tr>
								<td id="tdlabel"><label for="pr_no">PR No.<strong>*</strong> </label></td>
								<td colspan="2"><input type="text" name="pr_no" id="pr_no" required /></td>
							</tr>
							
							<tr>
								<td id="tdlabel"><label for="pr_date">PR Date<strong>*</strong> </label></td>
								<?php
								echo '<td colspan="2"><input type="date" name="pr_date" id="pr_date" max="'.$currentdate.'" required /></td>';
								?>
							</tr>
							
							<tr>
								<td id="tdlabel"><label for="sect">Section / Unit<strong>*</strong></label></td>
								<td colspan="2">	
								
									<select name="section" form="poform">
										  <?php 
										  for($x=0; $x<$ctrsect; $x++)
										  {
										  	echo "<option value='".$sectid[$x]."'>".$dept[$x]." - ".$sectname[$x]." </option>";
										  }
										  ?>
										
									</select>
								</td>
							</tr>

														
							<tr>
								<td id="tdlabel"><label for="reqby">Requested by<strong>*</strong> </label></td>
								<td colspan="2">
									<select name="reqby" form="poform" required>
										  <?php 
										  for($x=0; $x<$empctr; $x++)
										  {
										  	echo "<option value='".$empid[$x]."'>".$emplist[$x]." </option>";
										  }
										  ?>
										
									</select>

									</td>
							</tr>
							<tr>
								<td id="tdlabel"><label for="alobs">ALOBS no.<strong></strong> </label></td>
								<td colspan="2"><input type="text" name="alobs" id="alobs"  disabled/></td>
							</tr>
							<tr>
								<td id="tdlabel"><label for="alobsamt">ALOBS Amount<strong></strong> </label></td>
								<td colspan="2"><input type="text" name="alobsamt" id="alobsamt"  disabled /></td>
							</tr>
							<tr>
								<td id="tdlabel"><label for="purpose">Purpose<strong>*</strong> </label></td>
								<td colspan="2"><textarea rows="2" cols="100" name="purpose" id="purpose" required></textarea></td>
							</tr>
							<tr>
								<td id="tdlabel"><label for="req">PO/PR/RIS Remarks<strong></strong> </label></td>
								<td colspan="2"><textarea rows="2" cols="100" name="remarks" id="remarks" ></textarea></td>
							</tr>	
							
						</table>
						
						<div id="">
							<input type="submit" value="Save" />
						</div>
						
					</div>
					
				</form>
				
			</div>
		
		</div>
		
		<?php
			include 'footer.php';
		?>
	</div>
<script src="js/angular.min.js"></script>									

</body>
</html>