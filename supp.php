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
				<h2> Supplier's List </h2>
				<form id="poform" name="POForm1" method="GET" action="supp_frame.php" target="searchframe">
					<div id="tablediv2">	
						<table id="tablesearch" >
							<tr>
								<td colspan="2"> <input type="text" name="searchtxt" id="searchtxt" placeholder="Enter supplier's name here" /></td>
								<td> <input type="submit" name="searchbtn" id="searchbtn" value="Search" title="Search"></td>
							</tr>
							
						</table>
				<table id="issueth">
				<tr id="heading2"> 
					<td>
								
					</td>
					<td colspan="3">
						Supplier's Name		
					</td>
					<td colspan="2">
						Address		
					</td>
					<td colspan="2">
						Contact #		
					</td>
					

				</tr>
				</table>
					<iframe src="supp_frame.php" name="searchframe" frameborder="0" ></iframe>
					<a href='addsupp.php' target='_top'>Add a new Supplier</a>
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