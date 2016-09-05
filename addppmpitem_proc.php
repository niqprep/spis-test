<?php 

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	}

if (!isset($_POST['ppmpid']) or !isset($_POST['item']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: ppmp.php");
	} 
include 'database/dbconnect.php';
include 'functions.php';
$_SESSION['currentpage'] = "admin";

$ppmpid = $_POST['ppmpid'];
$itemstat = $_POST['itemstat'];
$rem = $_POST['rem'];
$item = $_POST['item'];
$qty = $_POST['qty'];
$src = $_POST['src'];
$procmeth = $_POST['procmeth'];
list($itemid, $cat) = explode("+", $item);


//check for duplicate item
$sqlitem = "SELECT * from ppmp_items where ppmpid = $ppmpid and itemid = $itemid ";
$chkitem = $conn->query($sqlitem);
if ($chkitem->num_rows > 0) 
	{
		echo "<script type=\"text/javascript\">
		alert(\"The item for this supplier and bid already exists. Please try again.\\n Thank you.\");
		history.go(-1);
		</script>";
	}
else
	{
		$userid = $_SESSION['userid'];
		$utype = $_SESSION['u_type'];
		$currdate = Date("Y-m-d H:i:s");

		$sql = "INSERT INTO ppmp_items (
								ppmpid,
								itemid,
								cat,
								qty,
								srcfund,
								procmeth,
								createdon,
								createdby,
								stat)
						values(
								'$ppmpid',
								'$itemid',
								'$cat',
								'$qty',
								'$src',
								'$procmeth',
								'$currdate',
								'$userid',
								'$itemstat')	";
		$mysql = $conn->query($sql);
		if($mysql)
		{
			echo '<script> type="text/javascript">';
			echo 'alert("Successfully added the item for this PPMP. \\n Thank you!");';
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