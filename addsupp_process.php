<?php

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 	

$_SESSION['currentpage'] = "supplier";

/*$usertype =$_SESSION['user_type'];*/
$userid = $_SESSION['userid'];	
include 'database/dbconnect.php';

$sname = $_POST['suppname'];
$address = $_POST['address'];
$tin = $_POST['tin'];
$ctel = $_POST['ctel'];
$ccp = $_POST['ccp'];
$email = $_POST['email'];
$site = $_POST['site'];
$stat = $_POST['stat'];
$rem = $_POST['remarks'];
$blist = $_POST['blist'];

//get the current date and time
$currdate = Date("Y-m-d h:i:s A");

$sql = "INSERT into supplier (name, address, tin, telcontact, cpcontact, email, website, blisted, supp_status, remarks, createdby, created) 
					values ('$sname', '$address', '$tin', '$ctel', '$ccp', '$email', '$site', '$blist', '$stat', '$rem', '$userid', '$currdate')";
$mysql = $conn->query($sql);
echo '<script type="text/javascript">'; 
echo 'alert("Supplier\'s information has been successfully added on the system.\\n Thank you.");'; 
echo 'window.location.href = "supp.php";';
echo '</script>';
