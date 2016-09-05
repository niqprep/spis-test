<?php

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 	

$_SESSION['currentpage'] = "supplier";

$usertype =$_SESSION['user_type'];
$userid = $_SESSION['userid'];	
include 'database/dbconnect.php';

$sname = ucwords(strtolower($_POST['name']));
$profid = $_POST['head'];
$desc = $_POST['sectdesc'];
$stat = $_POST['stat'];
$rem = $_POST['remarks'];

//get the current date and time
$currdate = Date("Y-m-d h:i:s A");

$sqlsrch = "Select * from dept where name = '$sname'";
$mysql01 = $conn->query($sqlsrch);
if ($mysql01 -> num_rows > 0 )
{
	echo '<script type="text/javascript">'; 
	echo 'alert("The section name already exists. Please try again.\\n Thank you.");'; 
	echo 'history.go(-1);';
	echo '</script>';
}
else
{
	$sql = "INSERT into dept (name, description, stat, remarks, createdby, created) 
					values ('$sname', '$desc', '$stat', '$rem', '$userid', '$currdate')";
	$mysql = $conn->query($sql);
	$deptid = $conn->insert_id;


	$sql02 = "INSERT into depthead (profileid, deptid, createdby, createdon) 
						values ('$profid', '$deptid', '$userid', '$currdate')";
	$mysql02 = $conn->query($sql02);

	echo '<script type="text/javascript">'; 
	echo 'alert("Section\'s information has been successfully added on the system.\\n Thank you.");'; 
	echo 'window.location.href = "adddept.php";';
	echo '</script>';
}



