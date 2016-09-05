<?php session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "receiving";

if (!isset($_SESSION['poid']))
{
	header ("location: rcvpo.php");
}
else
{
	$poid = $_SESSION['poid'];
}

$qry = "SELECT * FROM itrmc_db01.purchase_order WHERE purchase_order.id = '$poid'";
$result = $conn->query($qry);
	if($result->num_rows > 0)
	{
		while ($row = $result -> fetch_assoc()) 
		{
			$po_no = $row['po_number'];	
			$pterm = $row['pterm'];
			$cat = $row['category'];
			
		}
	}
	else
	{
		echo '<script type="text/javascript">'; 
		echo 'alert("No records found.\\nTry again.");'; 
		echo 'history.go(-1);';
		echo '</script>';
	}






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
				<h2> Receive Delivery </h2>
				
			</div>
		
		</div>
		
		<?php
			include 'footer.php';
		?>
	</div>
<script src="js/angular.min.js"></script>									

</body>
</html>