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
$userid = $_SESSION['userid'];
$utype = $_SESSION['u_type'];

if (!isset($_POST['bidsuppid']))
{
	header ("location: admin.php");
} 
else
{
	$bidsuppid =  $_POST['bidsuppid'];
}


$suppid =  $_POST['suppid'];
$bidstat =  $_POST['nw_stat'];
$remarks = $_POST['nw_remarks'];
$remarks = cleanthis($remarks);
//get the current date and time
$currdate = Date("Y-m-d h:i:s A");

$sql = "UPDATE bidsupp set supp_id = '$suppid',
							status = '$bidstat',
							modifiedby = '$userid',
							modifiedon = '$currdate',
							remarks = '$remarks'
						where bidsupp.id = $bidsuppid";
$mysql = $conn->query($sql);
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

