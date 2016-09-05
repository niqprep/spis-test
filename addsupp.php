<?php

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "supplier";




echo '<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>SPIS - Add New Supplier</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
	</head>
<body>
<div id="wholepage">
';	
			include 'header.php';
echo '<div id="mbody"><i id="title"><a href="supp.php">Proceed to Supplier\'s List</a><br>
						<a href="uploadbulksupp.php">Upload supplier\'s list</a>
					  </i>
			<h2> Add New Supplier </h2>
			

			<form name="additem" method="POST" action="addsupp_process.php"> 
				<table id="addstock">
					<tr>
						<td colspan="2"><h2>Supplier/Company Information</h2></td>

					</tr>
					<tr>
						<td><label for="item">Supplier\'s Name <strong>*</strong></label></td>
						<td>
						<input type="text" name="suppname" placeholder="Enter supplier\'s name here " required>
						</td>
					</tr>	
						
					<tr>
						<td><label for="desc">Address <strong>*</strong></label></td>
						<td><input type="text" name="address" placeholder="Enter supplier\'s address here"  required></td>
					</tr>
					
					<tr>
						<td><label for="cat">TIN <strong>*</strong></label></td>
						<td><input type="number" name="tin" placeholder="Enter TIN number here"  required></td>
					</tr>
					
					<tr>
						<td><label for="unit">Company Tel # </label></td>
						<td><input type="number" name="ctel" ></td>
					</tr>
					<tr>
						<td><label for="initbal">Company CP # </label></td>
						<td><input type="number" name="ccp" ></td>
					</tr>
					<tr>
						<td><label for="purprice">Email Address: </label></td>
						<td><input type="email" step="any" name="email" placeholder="mail@sample.com" ></td>
					</tr>
					<tr>
						<td><label for="rlvl">Website </label></td>
						<td><input type="url" name="site" placeholder="http://" ></td>
					</tr>
					<tr>
						<td><label for="Remarks">Remarks</label></td>
						<td><input type="text" name="remarks" ></td>
					</tr>
					<tr>
						<td><label for="stat">Status </label></td>
						<td>
							<select name="stat"> 
								<option value="1"> Active </option>
								<option value="0"> Inactive </option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td><label for="blist">Black Listed? </label></td>
						<td><input type="radio" name="blist" value="no" checked>No 
							<input type="radio" name="blist" value="yes">Yes
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<input type="submit">
						</td>
					</tr>
				</table>
			</form>
	  </div>';	
			include 'footer.php';
?>

</div>

<script src="js/angular.min.js"></script>									

</body>
</html> 
