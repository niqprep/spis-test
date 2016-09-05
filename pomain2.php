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

if (!isset($_POST['logno']))
{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: po.php");
}
else {
$x = 1;
$logno = $_POST['logno'];
}


?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>	
		
	</head>
<body>
<div id="wholepage"">		
		<?php
			include 'header.php';
		?>
		<div id="mbody">
			<div id="boxes">
				<div id="dialog" class="window">
				How many items do you want to log? | 
				<a href="#" class="close">Close</a>
				</div>
				
				<div id="mask"></div>
			</div>
				<div id="submenu">
				</div>
			
			<div id="maincontentpo">
				<h2> LOG PO AND RIS INFORMATION </h2>
				<form id="poform" name="POForm" method="post" action="process_logpo.php" ng-app="" ng-conroller="poCtrl" ng-init="category = 'supplies'">
					<div>	
					
						<table id="tablediv" cols="4" >
							<tr>
								<td id="tdlabel"><label for="category"> Please select a category<strong>*</strong> </label></td>
								<td><input type="radio"& name="category" value="supplies" id="equip" ng-model="category" ng-checked="true"> Supplies 
									<input type="radio"& name="category" value="equipment" id="equip" ng-model="category"> Equipment 
								</td>
							</tr>
							<tr id="subcatdd" ng-show="category == 'supplies'" >
								<td id="tdlabel"><label for="subcategory"> Select a sub category<strong>*</strong> </label></td>
								<td colspan="1">
									<select name="cat" form="poform">
									  <option value="supplies">Supplies</option>
									  <option value="surgical">Surgical</option>
									  <option value="drugs">Drugs & Meds</option>
									  <option value="lab">Laboratory</option>
									  <option value="hk">House Keeping</option>
									  <option value="ofc">Office</option>
									</select>
								</td>
							</tr>
							
							<tr>
								<td id="tdlabel"><label for="po_no">P.O. No.<strong>*</strong></label></td>
								<td><input type="number" name="po_no" id="po_no" min="25044" max="35044" required /></td>
							</tr>
							
							<tr>
								<td id="tdlabel"><label for="date">Date<strong>*</strong></label></td>
								<td><input type="date" name="date" id="date" required /></td>
								<td id="tdlabel"><label for="mode">Mode of Procurement<strong>*</strong></label> </td>
								<td><input type="text" name="mode" id="mode" required /></td>
							</tr>
							
							<tr>
								<td id="tdlabel" ><label for="suppliername"> Supplier	<strong>*</strong> </label></td>
								<td colspan="3"><input type="text" name="supplier" id="supplier" placeholder="Supplier Name" required /></td>
							<tr>
							
							<tr>
								<td id="tdlabel"><label for="supplieradd"> Address<strong>*</strong> </label></td>
								<td colspan="3"><input type="text" name="supplieradd" id="supplieradd" placeholder="Supplier Address" required /></td>
							<tr>
							
							<tr>
								<td id="tdlabel"><label for="suppliertin"> TIN<strong>*</strong> </label></td>
								<td colspan="2"><input type="number" name="suppliertin" id="suppliertin" placeholder="Supplier's TIN" min="1" required /></td>
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
									<select name="deltermd" form="poform">
									  <option value="day">day/s</option>
									  <option value="mth">month/s</option>
									  <option value="yr">year/s</option>
									</select>
								</td>
								<td> </td>
							</tr>
							
							<tr>
								<td id="tdlabel"><label for="deldate">Delivery date</label></td>
								<td colspan="3" ><input type="text" name="deldate" disabled/></td>
							</tr>
							
							<tr>
								<td id="tdlabel"><label for="payterm">Payment Term</label></td>
								<td colspan="3""><input type="text" name="payterm" id="payterm"/></td>
							</tr>
						</table>
						
						<table id="tabledesc" cols="6" ng-init="qty=0; cost=0; qty2=0; cost2=0; qty3=0; cost3=0">
							<tr id="thead">
								<td width="5%">Stock No.</td>
								<td>Unit<strong>*</strong></td>
								<td width="40%">Description<strong>*</strong></td>
								<td>Qty<strong>*</strong></td>
								<td>Unit Cost<strong>*</strong></td>
								<td>Total amount</td>
							</tr>
							
							<?php
								while ($x <= $logno){
									
									
									$x++;
								}
							
							?>
							
							
							
							
							
							<tr>
								<td>1</td>
								<td><input type="text" name="unit" id="unit" required /></td>
								<td><input type="text" name="desc" id="desc" required /></td>
								<td><input type="number" name="qty" id="qty" min="0" max="10000" value="0" ng-model="qty" required /></td>
								<td>Php <input type="number" name="unitcost" id="unitcost" value="0" ng-model ="cost" step="any" min="0" required /></td>
								<td><input type="text" name="amt" id="amt" step="any" value="{{(qty * cost) | currency : 'Php ' : 2}}" disabled/></td>
							</tr>
							<tr>
								<td>2</td>
								<td><input type="text" name="unit2" id="unit"/></td>
								<td><input type="text" name="desc2" id="desc"/></td>
								<td><input type="number" name="qty2" id="qty" min="0" max="10000" value="0" ng-model="qty2"/></td>
								<td>Php <input type="number" name="unitcost2" id="unitcost" value="0" ng-model ="cost2" step="any" min="0" /></td>
								<td><input type="text" name="amt" id="amt" step="any" value="{{(qty2 * cost2) | currency : 'Php ' : 2}}" disabled/></td>
							</tr>
							<tr>
								<td>3</td>
								<td><input type="text" name="unit3" id="unit" required /></td>
								<td><input type="text" name="desc3" id="desc" required /></td>
								<td><input type="number" name="qty3" id="qty" min="0" max="10000" value="0" ng-model="qty3" required /></td>
								<td>Php <input type="number" name="unitcost3" id="unitcost" value="0" ng-model ="cost3" step="any" min="0" required /></td>
								<td><input type="text" name="amt" id="amt" step="any" value="{{(qty3 * cost3) | currency : 'Php ' : 2}}" disabled/></td>
							</tr>
							
							
							<tr id="total">
								<td id="tdlabel" colspan="5"><label for="ttamt"><strong>TOTAL AMOUNT</strong></label></td>
								<td><input type="text" name="ttamt" id="ttamt" value="{{((qty * cost)+(qty2 * cost2)+(qty3 * cost3)) | currency : 'Php ' : 2}}" disabled/></td>
							</tr>

						</table>
						
						<table  id="tablediv" cols="4" >
							<tr id="thead">
								<td colspan="4"><strong>Requisition and Issue Slip Information</strong></td>
							</tr>
							
							<tr>
								<td id="tdlabel"><label for="dept">Dept / Section / Unit<strong>*</strong></label></td>
								<td colspan="2"><input type="text" name="dept" id="dept" required /></td>
							</tr>
							
							<tr>
								<td id="tdlabel"><label for="ofc">Office<strong>*</strong> </label></td>
								<td colspan="2"><input type="text" name="ofc" id="ofc" required /></td>
							</tr>
								
							<tr>
								<td id="tdlabel"><label for="req">Requested by<strong>*</strong> </label></td>
								<td colspan="2"><input type="text" name="req" id="req" required /></td>
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
<script src="angular.js"></script>									
										
</body>
</html>