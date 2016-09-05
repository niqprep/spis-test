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


if (!isset($_POST['logno']))
{
	header ("location: po.php");
}
else 
{
	$x = 1;
	$logno = $_POST['logno'];
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

	$date = $_POST['date']; //po tbl
	$mode = $_POST['mode']; //po tbl
	$supplier = $_POST['supplier']; //po tbl
	if (isset($_POST['delterm'])) //po tbl
	{
		$delterm = $_POST['delterm'];
		$deltermd = $_POST['deltermd'];
	}
	else
	{
		$delterm = '';
		$deltermd = '';
	}
	if (isset($_POST['payterm']))
	{
		$payterm = $_POST['payterm'];
	}
	else{
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
	 	//purchase order tbl values
		$qry = "INSERT into purchase_order(po_number,remarks,category,status,podate,mode,dterm,pterm,ddelivery,created,createdby,supplierid) 
				VALUES ('$po_no','$remarks','$cat','new','$date','$mode','$delterm','$payterm','$deltermd','$currdate','$userid','$supplier') ";
		$mysql = $conn->query($qry);

		//ris tbl values
		//$qry = "INSERT into ris(ris_no, createdby, created, status) VALUES ('$ris','$userid','$currdate','$ris_status') ";
		//$mysql = $conn->query($qry);

		//po ris pr tbl values for po# and ris id
		//$qry = "INSERT into porispr(po_no,ris_id) VALUES ('$po_no',LAST_INSERT_ID()) ";
		//$mysql = $conn->query($qry);

		//***Checks if PR no. has any existing pr no.
		//*** if none, it will insert a new record, otherwise, it will update the existing record
		
		//pr tbl values
		//old ---$qry = "INSERT into pr(pr_no, prdate, deptbranch, section, reqby, purpose, createdby, created, status) 
		//old ---VALUES ('$pr_no','$pr_date','$dept','$sect','$reqby','$purpose','$userid','$currdate','') ";
		//old ---$mysql = $conn->query($qry);
		//NEW 4-12-2016
		$qry = "INSERT INTO pr (id, pr_no, prdate, section, reqby, purpose, createdby, created, status)
				VALUES ('', '$pr_no','$pr_date','$sect','$reqby','$purpose','$userid','$currdate','new')
		  		ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id), 
		  								prdate = '$pr_date', 
		  								section = '$sect',
		  								reqby = '$reqby', 
		  								purpose = '$purpose',
		  								createdby = '$userid', 
		  								created = '$currdate'"; 
		$mysql = $conn->query($qry);

		//po ris pr tbl values for po# and pr
		$qry = "INSERT into porispr(po_no,pr_id) VALUES ('$po_no',LAST_INSERT_ID()) ";
		$mysql = $conn->query($qry);

		//OLD-- po ris pr tbl values for pr id :: NEW-- no need to update the porispr tbl kasi nasa taas na 4-12-16
		//$qry = "UPDATE porispr SET pr_id = LAST_INSERT_ID() WHERE po_no = '$po_no'";
		//$mysql = $conn->query($qry);


	$qrypoid = "SELECT id FROM purchase_order WHERE po_number = '$po_no'";
	$mysql = $conn->query($qrypoid);
	if ($mysql->num_rows > 0)
	{
		while($row = $mysql->fetch_assoc())
		{
			$poid= $row['id'];
		}	
	}

//po_poitems tbl
	$x= 1;
	$ttamt = 0;
	while ($x <= $logno)
	{
		$itema ="items".$x;
		$items[$x] = $_POST[$itema]; //get item id

		$qtya = "qty".$x;
		$qty[$x] = $_POST[$qtya];
		$unitcosta = "unitcost".$x;
		$unitcost[$x] = $_POST[$unitcosta];

		$tamt = $qty[$x] * $unitcost[$x];
		$ttamt = $ttamt + $tamt ;
		$qry = "INSERT into po_poitems(po_id, poitem_id, poitemstat, createddte, createdby, poqty, pounitcost) 
				VALUES ('$poid', '$items[$x]', 'new', '$currdate', '$userid', '$qty[$x]', '$unitcost[$x]')";
		$mysql = $conn->query($qry);
		
		$x++;

	}



	
	//echo $ttamt;
	$qry2 = "UPDATE purchase_order
				SET poamount = '$ttamt'
			WHERE id='$poid'";
	$mysql2 = $conn->query($qry2);

	
	echo '<script type="text/javascript">'; 
	echo 'alert("PO/PR/RIS details successfully logged.\\n Thank you.");'; 
	echo 'window.location.href = "searchpo.php"';
	echo '</script>';


}

