<?php
//start user session
session_start();

if (!isset($_SESSION['username']))
{
	header ("location: logform.php");
}

//get ID of the user for creation log 
$userid = $_SESSION['userid'];

//connect to the itrmc db
include 'database/dbconnect.php';

//get ris details
$ris = $_POST['risno'];$type = $_POST['type'];

//check for the ris number duplicate
$qry = "SELECT * FROM itrmc_db01.ris WHERE ris_no='$ris'";
$result = $conn->query($qry);
if ($result->num_rows > 0)
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Duplicate/Incorrect RIS no.\\n Please try again.");'; 
	echo 'history.go(-2);';
	echo '</script>';
}
else
{
	$deptid = $_POST['deptid']; 	
	$ctritems = $_POST['ctritems']; 
	
	
	//loop through itemid[] to get all values
	$itemid = array();
	if (is_array($_POST['itemid'])) 
	{
	    foreach($_POST['itemid'] as $value)
	    {
	      $itemid[] = $value;
	    }
	}
	//loop through bal[] to get all values
	$bal = array();
	if (is_array($_POST['bal'])) 
	{
	    foreach($_POST['bal'] as $value3)
	    {
	      $bal[] = intval($value3); 
	    }
	}

	//loop through qty[] to get all values
	$qty = array();
	if (is_array($_POST['qty'])) 
	{
	    foreach($_POST['qty'] as $value2)
	    {
	      $qty[] = $value2;
	    }
	}
		
	//get the current date and time
	$currdate = Date("Y-m-d h:i:s A");

	//insert to ris table
	$qryris = "INSERT into ris(ris_no, issued_on, rcvd_by, status, createdby, created) 
	 				VALUES ('$ris', '$currdate', '$deptid', 'issued', '$userid', '$currdate') ";
	$mysql = $conn->query($qryris);

//	//FOR OFFICE SUPPLIES and HOUSE KEEPING
	if ($type == 'hkos') 
	{		
		//insert to bal_log table 
		for ($i=0; $i < $ctritems; $i++) 
		{ 
			$balafter = $bal[$i] - $qty[$i];
			$item = $itemid[$i];
			$qryballog = "INSERT into bal_log(stockid, qtyn, dte_credeb, addsub, ris, balafter, createdby, createdon) 
		 				VALUES ('$item', '$qty[$i]', '$currdate', 'S', '$ris', '$balafter', '$userid', '$currdate') ";
			$mysql = $conn->query($qryballog);

			//update nonperi table
			$qryup = "UPDATE nonperi
						SET bal='$balafter',modifiedby='$userid', modifiedon='$currdate'
						WHERE stockid= $item";
			$mysql1 = $conn->query($qryup);		
			if ($mysql1-> num_rows > 0)
			{
				
			}
			else
			{
				//else, update peri tbl instead
				$qryup2 = "UPDATE peri
						SET bal='$balafter',modifiedby='$userid', modifiedon='$currdate'
						WHERE stockid= $item";
				$mysql2 = $conn->query($qryup2);	
			}	

		}

		echo '<script type="text/javascript">'; 
		echo 'alert("Inventory was successfully updated.\\n Thank you.");'; 
		echo 'window.location.href = "issuehkofc.php"';
		echo '</script>';	
	}

	//FOR OTHER SUPPLIES 
	else 
	{
		//insert to bal_log table 
		for ($i=0; $i < $ctritems; $i++) 
		{ 
			$balafter = $bal[$i] - $qty[$i];
			$item = $itemid[$i];
			$qryballog = "INSERT into bal_log(stockid, qtyn, dte_credeb, addsub, ris, balafter, createdby, createdon) 
		 				VALUES ('$item', '$qty[$i]', '$currdate', 'S', '$ris', '$balafter', '$userid', '$currdate') ";
			$mysql = $conn->query($qryballog);

			//update nonperi table
			$qryup = "UPDATE nonperi
						SET bal='$balafter',modifiedby='$userid', modifiedon='$currdate'
						WHERE stockid= $item";
			$mysql1 = $conn->query($qryup);	
			if ($mysql1-> num_rows > 0)
			{
				
			}
			else
			{
				//else, update peri tbl instead
				$qryup2 = "UPDATE peri
						SET bal='$balafter',modifiedby='$userid', modifiedon='$currdate'
						WHERE stockid= $item";
				$mysql2 = $conn->query($qryup2);	
			}
			
		}

		echo '<script type="text/javascript">'; 
		echo 'alert("Inventory was successfully updated.\\n Thank you.");'; 
		echo 'window.location.href = "issueoth.php"';
		echo '</script>';	


	}

	

}

