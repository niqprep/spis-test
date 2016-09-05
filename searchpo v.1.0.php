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

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
			
	</head>
<body>
<div id="wholepage">		
		<?php
			include 'header.php';
		?>
		<div id="mbody">
				<div id="submenu">
				</div>
			
			<div id="maincontentpo">
				<h2> Search PO </h2>
				<form id="poform" name="POForm1" method="GET" action="searchpo_frame.php" target="searchframe">
					<div id="tablediv2">	
						<table id="tablesearch" >
							<tr>
								<td colspan="2"> <input type="text" name="searchtxt" id="searchtxt" placeholder="Search" /></td>
								<td> <input type="submit" name="searchbtn" id="searchbtn" value="Search" title="Delete the Search field on the left to show all"></td>
							</tr>
							<tr>
								<td colspan="1">
									<label for="searchby"> Search by: </label>
								</td>
								<td colspan="1"> 
									<select name="searchby">
										  <option value="created" selected>Latest</option>
										  <option value="po_number">PO Number</option>
										  <option value="name">Supplier</option>
										  <option value="category">Category</option>
										  <option value="itemdesc">Items</option>
										  <option value="deptbranch">Department</option>
										  <option value="podate">PO Date (YYYY-MM-DD)</option>
										  <option value="status">Status</option>
										  <option value="Within">Within - (Supplier/PO#)</option>
										  <option value="Beyond">Beyond - (Supplier/PO#)</option>
									</select>

								</td>
							</tr>
						</table>
				<table id="record2">
				<tr id="heading2"> 
					<td>
						No.		
					</td>
					<td>
						PO Number		
					</td>
					<td>
						Supplier		
					</td>
					<td>
						Category		
					</td>
					<td colspan="3">
						1st Line Item / Items		
					</td>
					<td colspan="2">
						Requested by/Dept		
					</td>
					
					<td>
						PO Date		
					</td>
					<td colspan="2">
						Status		
					</td>
					<td colspan="2">
						Actions
					</td>
					<td colspan="1">
						Within/Beyond		
					</td>

				</tr>
				</table>
					<iframe src="searchpo_frame.php" name="searchframe" frameborder="0" ></iframe>
				
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