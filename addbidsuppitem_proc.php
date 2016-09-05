<?php 

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	}

if (!isset($_POST['bidsuppid']) or !isset($_POST['item']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: admin.php");
	} 
include 'database/dbconnect.php';
include 'functions.php';

$bidsuppid = $_POST['bidsuppid'];
$item = $_POST['item'];
list($itemid, $cat) = explode("+", $item);


//check for duplicate item
$sqlitem = "SELECT * from bidsuppitem where biddsupp_id = '$bidsuppid' and itemid = '$itemid' ";
$chkitem = $conn->query($sqlitem);
if ($chkitem->num_rows > 0) 
	{
		$uprice = $_POST['uprice'];		
		echo "<script type=\"text/javascript\">
			alert(\"The item for this supplier and bid already exists. Please try again.\\n Thank you.\");
			history.go(-1);
			</script>";
	}
else
	{
		$_SESSION['currentpage'] = "admin";
		$userid = $_SESSION['userid'];
		$utype = $_SESSION['u_type'];
		$currdate = Date("Y-m-d H:i:s");

		$uprice = $_POST['uprice'];
		$biditemstat = $_POST['biditemstat'];
		$rem = $_POST['rem'];
		
		$sql = "INSERT INTO bidsuppitem (
								itemid,
								biddsupp_id,
								uprice,
								cat,
								bsi_rem,
								createdon,
								createdby,
								istatus)
						values(
								'$itemid',
								'$bidsuppid',
								'$uprice',
								'$cat',
								'$rem',
								'$currdate',
								'$userid',
								'$biditemstat')	";
		$mysql = $conn->query($sql);
		if($mysql)
		{
			echo '<script> type="text/javascript">';
			echo 'alert("Successfully added the item for this bid. \\n Thank you!");';
			echo 'history.go(-2);';
			echo '</script>';
		}
		else
		{
			die("
				<script type=\"text/javascript\">
				alert(\"Sorry, something went wrong, please try again.\\n Thank you.\");
				history.go(-1);
				</script> 
				");
		}
	}