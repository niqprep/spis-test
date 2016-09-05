<?php
//start user session
session_start();

if (!isset($_SESSION['username']))
{
	header ("location: logform.php");
}
if (!isset($_SESSION['userid']))
{
	$username = $_SESSION['username'];
	 $qryuser = "SELECT id FROM user WHERE uname = '$username'";
	 $mysql = $conn->query($qryuser);
	 	if ($mysql->num_rows > 0)
		{
			while($row = $mysql->fetch_assoc())
			{
				$userid= $row['id'];
			}	
		}
	 $_SESSION['userid'] = $userid;
}
else
{
	$userid = $_SESSION['userid'];
}
//connect to the itrmc db
include 'database/dbconnect.php';

if (isset($_POST['poid']) and isset($_POST['po_poitemid0'])) 
{
	//get PO details
	echo $poid = $_POST['poid'];
	echo "//poid<br>";
	echo $suppid = $_POST['supplier'];
	echo "<br>";
	echo $po_no = $_POST['po_no'];
	echo "<br>";
	//echo $podate = $_POST['podate'];
	$podate = new DateTime($_POST['podate']);
	echo $podate = $podate->format('Y-m-d H:i:s');

	echo "<br>";
	echo $modeproc = $_POST['mode'];
	echo "<br>";

	echo $delterm = $_POST['delterm']; //number of days
	echo "<br>";
	echo $deldays = $_POST['daymthdel'];
	echo "<br>";
	echo $payterm = $_POST['payterm'];
	echo "<br>";
	echo $purpose = $_POST['purpose'];
	echo "<br>";
	echo $remarks = $_POST['remarks'];
	$modifiedby = $userid;
	echo $currdate = Date("Y-m-d H:i:s");
	echo $prid = $_POST['prid'];


	echo "<br>";

	echo $no_items = $_POST['no_items'];
	echo "/////////////////////////////////////////////////////////////////////////////////////////////<br><br>";
	$ttamt = 0;
	//insert every items in a variable
	for ($x=0 ; $x < $no_items ; $x++ )
	{ 
		/*po_poitemid  -ito ung basis for saving ng edited n items ng purchase order */
		$po_poitemida = "po_poitemid".$x;
		echo $po_poitemid[$x] = $_POST[$po_poitemida];
		echo "//popoitemid<br>";

		$qtya = "qty".$x;
		echo $qty[$x] = $_POST[$qtya];
		echo "//qty<br>";
		$unitcosta = "unitcost".$x;
		echo $unitcost[$x] = $_POST[$unitcosta];
		echo "//unitcost<br>";
		$itema ="items".$x;
		echo $items[$x] = $_POST[$itema]; //get item id
		echo "//itemsid<br>";
		$tamt = $qty[$x] * $unitcost[$x];
		echo $ttamt = $ttamt + $tamt ;
		echo "//totalamount<br><br>";

//////////////////////////////////////////////////////////////////////////////////*******************************************
			$qrypoitems = "UPDATE po_poitems
				SET poitem_id = '$items[$x]',
					 poqty = '$qty[$x]',
					 pounitcost = ' $unitcost[$x]',
					 modifieddte = '$currdate',
					 modifiedby = '$userid'
				WHERE id = '$po_poitemid[$x]' and 
					  po_id = '$poid'";
			$mysqlpoitems = $conn->query($qrypoitems);

	}

	$qrypo = "UPDATE purchase_order
				SET remarks = '$remarks',
					podate = '$podate',
					mode = '$modeproc',
					dterm = '$delterm',
					poamount = '$ttamt',
					pterm = '$payterm',
					modified = '$currdate',
					modifiedby = '$modifiedby',
					supplierid = '$suppid'
				WHERE purchase_order.id = '$poid' and 
					  po_number = '$po_no'";
	$mysqlpo = $conn->query($qrypo);


	$qryris = "UPDATE pr
				SET purpose = '$purpose'
				WHERE id = '$prid'";
	$mysqlris = $conn->query($qryris);

		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully edited the PO details of '.$po_no.'.\\n Thank you.");'; 
		echo 'window.location.href = "searchpo.php"';
		echo '</script>';
}
else
{
	
	echo '<script type="text/javascript">'; 
	echo 'alert("The site you\'re trying to view is not yet available. \n Please try again.");'; 
	echo 'window.location.href = "searchpo.php"';
	echo '</script>';
	//if nag by pass lang ng URL redirect to search po page 
}




