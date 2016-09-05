<?php
//start user session
session_start();

if (!isset($_SESSION['username']) or !isset($_SESSION['userid']))
{
	header ("location: logform.php");
}
else
{
	//get ID of the user for creation of log 
	 $userid = $_SESSION['userid'];	
}

if (!isset($_POST['num_items']) or !isset($_POST['bidsuppid1']))
{
	header ("location: po.php");
}
else 
{
	$x = 1;
	$logno = $_POST['num_items'];
	$bidsuppid = $_POST['bidsuppid1'];
}

//connect to the itrmc db
include 'database/dbconnect.php';


//get po details
$cat = $_POST['cat']; //po tbl
$po_no = $_POST['po_no']; //po tbl
//check for the po number duplicate
$qry = "SELECT * FROM purchase_order WHERE po_number='$po_no'";
$result = $conn->query($qry);
if ($result->num_rows > 0)
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Duplicate PO No.\\nTry again.");'; 
	//cant use history go here bec the browser will ask 'confirm submission..'
	//use get instead of post to get the previously entered data 4/15/2016
	//echo 'history.go(-1);';
	echo 'window.location.href = "pomain.php"';
	echo '</script>';
}
else
{

	$date = $_POST['podate']; //po tbl
	$supplier = $_POST['suppid']; //po tbl
	if (isset($_POST['delterm'])) //po tbl
	{
		$delterm = $_POST['delterm'];		
	}
	else
	{
		$delterm = '0';
	}

	$mode = $_POST['mode'];
	$daymthdel = $_POST['daymthdel']; //Calendar days or CD


	if (isset($_POST['payterm']))
	{
		$payterm = $_POST['payterm'];  //cash COD etc
	}
	else	
	{
		$payterm = " ";
	}

	//$conforme = $_POST['conforme'];
	//$confdate = $_POST['confdate'];
	//$approvedate = $_POST['approvedate'];

	//$dept = $_POST['dept']; //pr tbl
	$sect = $_POST['section']; //pr tbl
	$reqby = $_POST['reqby']; //pr tbl

	//$ris = $_POST['risno']; //ris tbl
	//$ris_status = $_POST['ris_status']; //ris tbl
	$pr_no = $_POST['pr_no']; //pr tbl
	$pr_date = $_POST['pr_date'];  //pr tbl
	//$alobs = $_POST['alobs']; //po tbl
	//$alobsamt = $_POST['alobsamt']; //po tbl
	$purpose = $_POST['purpose']; //pr tbl
	//$remarks = $_POST['remarks']; //po tbl
	if (isset($_POST['remarks']))
	{
		$remarks = $_POST['remarks'];
	}
	else{
		$remarks = " ";
	}

	//$currdate = Date("Y-m-d h:i:s A");
	$currdate = Date("Y-m-d H:i:s");
	
	$qry06 = "START TRANSACTION";
	$sqlstart = $conn->query($qry06);
	$qrypo ="INSERT into 
					purchase_order(
							po_number,
							remarks,
							category,
							status,
							podate,
							mode,
							dterm,
							pterm,
							ddelivery, 
							created,
							createdby,
							supplierid) 
					VALUES ('$po_no',
							'$remarks',
							'$cat',
							'new',
							'$date',
							'$mode',
							'$delterm',
							'$payterm',
							'$daymthdel', 
							'$currdate',
							'$userid',
							'$supplier'); ";
	$mysql = $conn->query($qrypo);
	if (!$mysql) 
	{
		//rollback CHANGES
		$qryroll = "ROLLBACK;";
		$mysqlroll = $conn->query($qryroll);
		echo '<script type="text/javascript">'; 
		echo 'alert("Something went wrong in Purchase Order table.\\n Please try again. Thank you.");'; 
		echo 'history.go(-3);';
		echo '</script>';

	}
	
	//if successfully saved to purchase order table, proceed into saving the pr
	$qry = "INSERT INTO pr (id,
							pr_no, 
							prdate, 
							section, 
							reqby, 
							purpose, 
							createdby, 
							created,
							status)
			VALUES ('', 
							'$pr_no',
							'$pr_date',
							'$sect',
							'$reqby',
							'$purpose',
							'$userid',
							'$currdate',
							'1')
	 	  	ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id), 
			  								prdate = '$pr_date', 
			  								section = '$sect',
			  								reqby = '$reqby', 
			  								purpose = '$purpose',
			  								modifiedby = '$userid', 
			  								modified = '$currdate'"; 
	$mysqlpr = $conn->query($qry);
	if (!$mysqlpr) 
	{
		//rollback CHANGES
		$qryroll = "ROLLBACK;";
		$mysqlroll = $conn->query($qryroll);
		echo '<script type="text/javascript">'; 
		echo 'alert("Something went wrong in the PR\'s table.Rolling back changes.\\n Please try again. Thank you.");'; 
		echo 'history.go(-3);';
		echo '</script>';
		
	}
	
	//if successful for PR, continue to PR RIS PO tbl
	//po ris pr tbl values for po# and pr
	$qryprp = "INSERT into porispr(po_no,pr_id) VALUES ('$po_no',LAST_INSERT_ID()) ";
	$mysqlprp = $conn->query($qryprp);
	if (!$mysqlprp) 
	{
		//rollback CHANGES
		$qryroll = "ROLLBACK;";
		$mysqlroll = $conn->query($qryroll);
		echo '<script type="text/javascript">'; 
		echo 'alert("Something went wrong in the PORISPR\'s table.Rolling back changes.\\n Please try again. Thank you.");'; 
		echo 'history.go(-3);';
		echo '</script>';
		
	}

	//get id of the recently added po
	$qrypoid = "SELECT id FROM purchase_order WHERE po_number = '$po_no'";
	$mysqlpoid = $conn->query($qrypoid);
	if ($mysqlpoid->num_rows > 0)
	{
		while($row = $mysqlpoid->fetch_assoc())
		{
			$poid= $row['id'];
		}	
	}
	if (!$mysqlpoid) 
	{
		//rollback CHANGES
		$qryroll = "ROLLBACK;";
		$mysqlroll = $conn->query($qryroll);
		echo '<script type="text/javascript">'; 
		echo 'alert("Something went wrong in the getting the PO id.Rolling back changes.\\n Please try again. Thank you.");'; 
		echo 'history.go(-3);';
		echo '</script>';
	}

	//po_poitems tbl
	$x= 0;
	$ttamt = 0;
	while ($x < $logno)
	{
		$itema ="itemid".$x;
		$items[$x] = $_POST[$itema]; //get item id
		$bsi_ida ="bsi_id".$x;
		$bsi_id[$x] = $_POST[$bsi_ida]; //get bsi_id

		$qtya = "qty".$x;
		$qty[$x] = $_POST[$qtya];
		$unitcosta = "unitcost".$x;
		$unitcost[$x] = $_POST[$unitcosta];

		$tamt = $qty[$x] * $unitcost[$x];
		$ttamt = $ttamt + $tamt ;
		$qry = "INSERT into po_poitems(po_id, poitem_id, poitemstat, createddte, createdby, poqty, pounitcost, bsi_id) 
				VALUES ('$poid', '$items[$x]', 'new', '$currdate', '$userid', '$qty[$x]', '$unitcost[$x]', '$bsi_id[$x]')";
		$mysql = $conn->query($qry);
		
		$x++;
	}

	if (!$mysql) 
	{
		//rollback CHANGES
		$qryroll = "ROLLBACK;";
		$mysqlroll = $conn->query($qryroll);
		echo '<script type="text/javascript">'; 
		echo 'alert("Something went wrong in the PO items table.Rolling back changes.\\n Please try again. Thank you.");'; 
		echo 'history.go(-3);';
		echo '</script>';
	}

	$qry2 = "UPDATE purchase_order
				SET poamount = '$ttamt'
				WHERE id='$poid'";
	$mysql2 = $conn->query($qry2);

	if (!$mysql2) 
	{
		//rollback CHANGES
		$qryroll = "ROLLBACK;";
		$mysqlroll = $conn->query($qryroll);
		echo '<script type="text/javascript">'; 
		echo 'alert("Something went wrong in the PO items table.Rolling back changes.\\n Please try again. Thank you.");'; 
		echo 'history.go(-3);';
		echo '</script>';
	}
	else
	{
		$qrycom = "COMMIT;";
		$mysqlcom= $conn->query($qrycom);

		if($mysqlcom)
		{
			echo '<script type="text/javascript">'; 
			echo 'alert("PO/PR/RIS with '.$x.' item/s is added successfully.\\n Thank you.");'; 
			echo 'window.location.href = "searchpo.php"';
			echo '</script>';
		}
	}	
	
	






}


