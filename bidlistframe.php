<?php

session_start();
include 'functions.php';

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	}

//check the passed bidding date data
if (!isset($_GET['date']) || !isset($_GET['prno']))
{
	echo '<script type="text/javascript">'; 
	echo 'top.location.href = "index.php";';
	echo '</script>';
}
if(isset($_GET['date']))
{
	$biddte = $_GET['date'];
	$prno = cleanthis($_GET['prno']);
} 	
if(isset($_GET['prno']))
{
	$biddte = cleanthis($_GET['date']);
	$prno = cleanthis($_GET['prno']);
} 

/*$usertype =$_SESSION['user_type'];*/
$userid = $_SESSION['userid'];	
include 'database/dbconnect.php';

/*$query = $conn->query("SELECT id from pr where pr_no = '$prno'") or die($conn->error());  // Check if your query has any error
$row = mysqli_fetch_array($query);
print_r($row);
$prid = array_values($row[0]);*/
$prid = array_values(mysqli_fetch_array($conn->query("SELECT id from pr where pr_no = '$prno'")))[0];
//echo $prid;
$sql = "SELECT bid_id, description FROM bidding where biddingdte = '$biddte' and bid_stat = '1'";
$mysql = $conn->query($sql);


if ($mysql)
{
	$biddte2 = new DateTime($biddte);
	$biddte2 = $biddte2->format('F d, Y');
	echo '<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<title>ITRMC - Supply & Property System</title>
			<link href="css/style.css" rel="stylesheet" type="text/css" />		
		</head>
	<body>
		<table id="potbls">
			<tr><td>'.$biddte2.'</td></tr>';
		if ($mysql->num_rows > 0)
		{
			while($row = $mysql->fetch_assoc())
			{
				
				echo '<tr><td><a href="po2.php?bidid='.$row['bid_id'].'&prid='.$prid.'" target="_parent"> '.$row['description'].'</a></td></tr>';

			}	
		}
		echo'
		</table>
	</body>
	</html>';


}
else
{

	echo '<script type="text/javascript">'; 
	echo 'alert("Something went wrong. Please try again later.\\n Thank you.");'; 
	echo 'top.location.href = "po.php";';
	echo '</script>';
}
