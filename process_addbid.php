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
$userid = $_SESSION['userid'];

if (!isset($_POST['biddesc']) or !isset($_POST['biddate']) )
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: admin.php");
	} 
echo $biddesc = $_POST['biddesc'];
echo $biddate = $_POST['biddate'];
echo $bidstat = $_POST['bidstat'];
echo $bidrem = $_POST['bidrem'];
echo $createdby = $userid;
$currdate = Date("Y-m-d H:i:s");

$qry = "INSERT INTO bidding(biddingdte,
							description,
							bid_stat,
							createdby,
							createdon,
							biddingrem)
					values('$biddate',
							'$biddesc',
							'$bidstat',
							'$createdby',
							'$currdate',
							'$bidrem')";


$mysqln = $conn->query($qry);

if ($mysqln)
	{
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully added '.$biddesc.' with the date '.$biddate.'. \\n Thank you.");'; 
		echo 'window.location.href = "admin.php"';
		echo '</script>';
	}
	else
	{
		die("<script type='text/javascript'>
			alert('Sorry! Something went wrong on adding bidding info! Please try again later. \\n Thank you.');
			window.location.href = 'admin.php'
			</script>
		");
	}




?>

