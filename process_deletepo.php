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

if (!isset($_POST['poid']) or !isset($_POST['candte']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: searchpo.php");
	} 
$poid = $_POST['poid'];
$pono = $_POST['pono'];
$oldstat = $_POST['statold'];
$reason = $_POST['reason'];
$candte = $_POST['candte'];
$canby = $userid;

$currdate = Date("Y-m-d H:i:s");
$currdate = Date("Y-m-d");

$qryveri = "SELECT * from purchase_order where id = '$poid'";
$mysqlveri = $conn->query($qryveri);
if($mysqlveri->num_rows > 0)
{
	while ($row = $mysqlveri->fetch_assoc())
	{
		$status = $row['status'];

	}
}

//if PO status is already cancelled, then die
if ($status == 'cancelled') 
{
	echo "<script type='text/javascript'>
			alert('Sorry! PO is already in archive/cancelled status! Please try again. \\n Thank you.');
			window.location.href = 'searchpo.php'
			</script>";
}

//if PO status is not yet cancelled, continue with the update
$qrypoitems = "UPDATE po_poitems, 
						purchase_order
					SET po_poitems.cancelleddte = '$candte',
						po_poitems.cancelledby = '$canby',
						po_poitems.poitemstat = 'cancelled',
						
						purchase_order.status = 'cancelled',
						purchase_order.modifiedby = '$canby',
						purchase_order.modified = '$currdate',
						purchase_order.canceldte = '$candte'

				where po_poitems.po_id = '$poid'and
						purchase_order.id = po_poitems.po_id and
						purchase_order.po_number = '$pono'";
$mysqln = $conn->query($qrypoitems);
//pop up message for successful transaction (po_poitems, purchase_order)
if ($mysqln) 
{
	//if PO status is not yet cancelled and the update is successful, continue with the insert data in cancelledpo tbl
	$qrycan = "INSERT INTO cancelledpo (can_stat, 
										po_id,
										canceldte,
										cancelledby,
										can_rem,
										prev_stat) 
								VALUES ('1',
										'$poid',
										'$candte',
										'$canby',
										'$reason',
										'$oldstat')";
	$mysqlcan = $conn->query($qrycan);
	if ($mysqlcan)
	{
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully forwarded PO# '.$pono.' to Archives. \\n Thank you.");'; 
		echo 'window.location.href = "searchpo.php"';
		echo '</script>';
	}
	else
	{
		die("<script type='text/javascript'>
			alert('Sorry! Something went wrong on cancelled PO tables! Please try again later. \\n Thank you.');
			window.location.href = 'searchpo.php'
			</script>
		");
	}
}
else
{
	die("<script type='text/javascript'>
			alert('Sorry! Something went wrong! Please try again later. \\n Thank you.');
			window.location.href = 'searchpo.php'
			</script>
		");
}


	



?>

