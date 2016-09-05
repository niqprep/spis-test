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

if (!isset($_POST['poid']) or !isset($_POST['proc']) or !isset($_POST['datetimepo']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: searchpo.php");
	} 
$poid = $_POST['poid'];
$proc = $_POST['proc'];
$pono = $_POST['pono'];
$currdate = Date("Y-m-d H:i:s");
$procdtedte = $_POST['datetimepo'];



//IF process is FORWARD TO BUDGET
if ($proc == 'tobudget') 
{
	$qrypoitems = "UPDATE po_poitems, purchase_order
					SET po_poitems.tobudgetby = '$userid',
						po_poitems.tobudgetdte = '$procdtedte',
						po_poitems.poitemstat = '$proc',
						
						purchase_order.status = '$proc',
						purchase_order.modifiedby = '$userid',
						purchase_order.modified = '$currdate'
				where po_poitems.po_id = '$poid'and
						purchase_order.id = po_poitems.po_id and
						purchase_order.po_number = '$pono'";
	

}
//IF process is from BUDGET 
elseif ($proc == 'new') 
{
	$qrypoitems = "UPDATE po_poitems, purchase_order
					SET po_poitems.backtonewby = '$userid',
						po_poitems.backtonewdte = '$procdtedte',
						po_poitems.poitemstat = '$proc',

						purchase_order.status = '$proc',
						purchase_order.modifiedby = '$userid',
						purchase_order.modified = '$currdate'
				where 	po_poitems.po_id = '$poid' and
						purchase_order.id = po_poitems.po_id and
						purchase_order.po_number = '$pono'";
	
}
elseif ($proc == 'fromMCC') 
{
	$alobsno = $_POST['alobsno'];
	$alobsamt = $_POST['alobsamt'];
	$alobstyp = $_POST['alobstyp'];
	$alobsdte = $_POST['alobsdte'];
	$datetimercvd = $_POST['datetimercvd'];

	$qrypoitems = "UPDATE po_poitems, purchase_order
					SET po_poitems.rcvdapprovdby = '$userid',
						po_poitems.rcvdapprovdte = '$datetimercvd',
						po_poitems.approveddte = '$procdtedte',
						po_poitems.poitemstat = '$proc',
						purchase_order.status = '$proc',
						purchase_order.alobs = '$alobsno',
						purchase_order.alobsamt = '$alobsamt',
						purchase_order.alobstyp = '$alobstyp',
						purchase_order.alobsdte = '$alobsdte',
						purchase_order.approve = '$procdtedte'

				where po_poitems.po_id = '$poid' and
						purchase_order.id = po_poitems.po_id and 
						purchase_order.po_number = '$pono' ";
	
}
elseif ($proc == 'toSupplier') 
{
	
	echo $confby = $_POST['confby'];
	$frsuppdte = $_POST['frsuppdte'];

	$qrypoitems = "UPDATE po_poitems, purchase_order
					SET purchase_order.confdate = '$procdtedte',
						purchase_order.conformeby = '$confby',
						purchase_order.tosuppby = '$userid',
						purchase_order.frsuppdte = '$frsuppdte',
						
						po_poitems.poitemstat = '$proc',
						
						purchase_order.status = '$proc',
						purchase_order.modifiedby = '$userid',
						purchase_order.modified = '$currdate'
				where po_poitems.po_id = '$poid'and
						purchase_order.id = po_poitems.po_id and 
						purchase_order.po_number = '$pono' ";
	
}
elseif ($proc == 'restore') 
{
	
	$remarks = $_POST['reason'];
	$prevstat = $_POST['prevstat'];
	
	$qrypoitems = "UPDATE po_poitems, purchase_order, cancelledpo
					SET po_poitems.poitemstat = '$prevstat',

						purchase_order.status = '$prevstat',
						purchase_order.modifiedby = '$userid',
						purchase_order.modified = '$currdate',

						cancelledpo.can_stat = '0',
						cancelledpo.restoredby = '$userid',
						cancelledpo.restoreddte = '$procdtedte',
						cancelledpo.restorem = '$remarks'


				where po_poitems.po_id = '$poid'and
						purchase_order.id = po_poitems.po_id and 
						purchase_order.po_number = '$pono' and
						cancelledpo.po_id = '$poid' and 
						cancelledpo.prev_stat = '$prevstat' and
						cancelledpo.can_stat = '1' and
						purchase_order.canceldte = cancelledpo.canceldte";
}

$mysqln = $conn->query($qrypoitems);



//pop up message for successful transaction
switch ($proc)
{
	case 'tobudget':
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully forwarded PO# '.$pono.' to Budget\'s Section for MCC\'s approval. \\n Thank you.");'; 
		echo 'window.location.href = "searchpo.php"';
		echo '</script>';
		break;
	case 'new':
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully reverted PO# '.$pono.' to NEW PO. \\n Thank you.");'; 
		echo 'window.location.href = "searchpo.php"';
		echo '</script>';
		break;
	case 'fromMCC':
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully received the approved PO# '.$pono.' from MCC. \\n Thank you.");'; 
		echo 'window.location.href = "searchpo.php"';
		echo '</script>';
		break;
	case 'toSupplier':
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully forwarded to and received from the respective supplier of the PO# '.$pono.'.\\n Thank you.");'; 
		echo 'window.location.href = "searchpo.php"';
		echo '</script>';
		break;
	case 'restore':	
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully restored PO#  '.$pono.'. \\n Thank you.");'; 
		echo 'window.location.href = "searchpo.php"';
		echo '</script>';
		break;
	default:
		# code...
		break;
}




?>

