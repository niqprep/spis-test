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
$userid = $_SESSION['userid'];

if (!isset($_POST['bidid']))
{
	header ("location: admin.php");
} 
else
{
	$bidid =  $_POST['bidid'];
}



$biddte = $_POST['nw_biddte'];
$descr = $_POST['nw_descr'];
$bidstat = $_POST['nw_stat'];
$remarks = $_POST['nw_remarks'];
$modby = $userid;

$currdate = Date("Y-m-d H:i:s");

$qry = "UPDATE bidding SET 
					biddingdte = '$biddte',
					description = '$descr',
					bid_stat = '$bidstat',
					modifiedby = '$modby',
					modifiedon = '$currdate',
					biddingrem = '$remarks'
					WHERE bid_id = '$bidid'";
$mysql = $conn->query($qry);
if($mysql)
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Successfully completed the changes. \\n Thank you.");'; 
	echo 'window.top.location.href = "admin.php"';
	echo '</script>';
}
else
{
	die("<script type='text/javascript'>
		alert('Sorry! Something went wrong upon altering the database! Please try again later. \\n Thank you.');
		window.top.location.href = 'admin.php'
		</script>
	");
}


	



?>

