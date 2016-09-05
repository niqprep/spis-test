<?php

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "admin";

if (isset($_GET['cat']))
{
	$cat = $_GET['cat'];
}
else{
	$cat = 'n';
}

$currdate = Date("Y-m-d");

$code = array();
$desc = array();
$ctr = 0;
$sql = "SELECT * from cat where stat = 'Active'";
$result = $conn->query($sql);
if ($result -> num_rows > 0) 
{
	while($row = $result-> fetch_assoc())
	{
		$code[] = $row['catcode'];
		$desc[] = $row['catdesc']; 
		$ctr++;
	}
}


echo '<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>SPIS - Add New Item</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
	</head>
<body>
<div id="wholepage">
';	
			include 'header.php';
echo '<div id="mbody"><i  id="title">
						<a href="uploadbulkitem.php">Upload item\'s list</a>
					  </i>
			<h2> Add New Item </h2>
			<form name="additem" method="POST" action="additem_process.php"> 
				<table id="addstock">
					<tr>
						<td><label for="item">Item Name <strong>*</strong></label></td>
						<td>
						<input type="text" name="itemname" placeholder="e.g. Bond Paper, Dishwashing" autofocus required>
						</td>
					</tr>
					
					<tr>
						<td><label for="desc">Item Description </label></td>
						<td><input type="text" name="itemdesc" placeholder="e.g. Long 8x13, 300ml with lemon" ></td>
					</tr>
					
					<tr>
						<td><label for="cat">Category <strong>*</strong></label></td>
						<td><select name="cat" >';
								for ($x=0; $x < $ctr; $x++) 
								{ 
									if ($code[$x] == $cat) 
									{
										echo '<option value="'.$code[$x].'" selected> '.$desc[$x].' </option>';
									}
									else
									{
										echo '<option value="'.$code[$x].'"> '.$desc[$x].' </option>';
									}
								}


					  echo '</select>
						</td>
					</tr>
					<tr>
						<td><label for="brand">Brand <i> (if any)</i></label></td>
						<td><input type="text" name="brand" ></td>
					</tr>
					<tr>
						<td><label for="unit">Unit <strong>*</strong></label></td>
						<td><input type="text" name="unit" required></td>
					</tr>
					<tr>
						<td><label for="initbal">Initial Balance <strong>*</strong></label></td>
						<td><input type="number" name="initbal" min="0" value="0" required></td>
					</tr>
					<tr>
						<td><label for="purprice">Purchased Price <strong>*</strong></label></td>
						<td><input type="number" step="any" name="purprice" min="0" required></td>
					</tr>
					<tr>
						<td><label for="exp">Expiration Date <i>(if any)</i> </label></td>
						<td><input type="date" name="exp" min="'.$currdate.'" ></td>
					</tr>
					<tr>
						<td><label for="rlvl">Reorder Level <strong>*</strong></label></td>
						<td><input type="number" name="rlvl" min="0" required></td>
					</tr>
					
					<tr>
						<td><label for="Remarks">Remarks</label></td>
						<td><input type="text" name="remarks" ></td>
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
