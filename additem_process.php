<?php
session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 

$usertype =$_SESSION['user_type'];
$userid = $_SESSION['userid'];	

include 'database/dbconnect.php';

if(!isset($_POST['itemname']))
{
	header("location: additem.php");
}

$itemname = strip_tags(trim($_POST['itemname']));
$itemdesc = strip_tags(trim($_POST['itemdesc']));
$unit = strip_tags(trim($_POST['unit']));
$brand = strip_tags(trim($_POST['brand']));
$remarks = strip_tags(trim($_POST['remarks']));

if ( (empty($itemname)) OR (empty($unit)) )
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Please enter a valid value.\\n Thank you.");'; 
	echo 'history.go(-1);';
	echo '</script>';
	
}
else
{	
	$itemname = mysql_real_escape_string(htmlspecialchars($itemname));
	$itemdesc = mysql_real_escape_string(htmlspecialchars($itemdesc));
	$cat = strip_tags($_POST['cat']);
	$brand = mysql_real_escape_string(htmlspecialchars(strip_tags($brand)));
	$unit = mysql_real_escape_string( htmlspecialchars(strip_tags($unit)) );
	$initbal = $_POST['initbal'];
	$purprice = $_POST['purprice'];
	$remarks = mysql_real_escape_string($remarks);
	$rlvl = $_POST['rlvl'];
	if (isset($_POST['exp']))
	{
		$exp = $_POST['exp'];
	}
	else
	{
		$exp = '';
	}
	
	
	//get the current date and time
	$currdate = Date("Y-m-d h:i:s A");
	$dateonly = Date("Y-m-d");

	if (($cat == 'OS') OR ($cat == 'HK')) 
	{
		//add record to the stocks table
		$sql01 = "INSERT INTO itrmc_db01.stocks (item_name, `desc`, category, purchase_price, brand, unit, s_status, createdby, createdon, rlvl, remarks) 
										 VALUES ('$itemname', '$itemdesc', '$cat', '$purprice', '$brand', '$unit', 'Active', '$userid', '$currdate', '$rlvl', '$remarks')";
		$mysql01 = $conn->query($sql01);
		$stockid = $conn->insert_id;

		//add record to the bal_log table
		$sql03 = "INSERT INTO itrmc_db01.bal_log (stockid, qtyn, dte_credeb, addsub, purprice, balafter, createdby, createdon)
										  VALUES ('$stockid', '$initbal', '$dateonly', 'A', '$purprice', '$initbal', '$userid', '$currdate')";
		$mysql03 = $conn->query($sql03);
		$logid = $conn->insert_id;


		//if the item is perishable,add to peri
		if ($exp != '')
		{			
			//add record to the peri table
			$sql02 = "INSERT INTO itrmc_db01.peri (stockid, bal, purchase_date, createdby, createdon)
											  VALUES ('$stockid', '$initbal', '$currdate', '$userid', '$currdate')";
			$mysql02 = $conn->query($sql02);

			$sqlexp = "INSERT INTO itrmc_db01.expire (type, stockid, logid, expdte)
												values ('S', '$stockid', '$logid', '$exp')";
			$mysqlexp = $conn->query($sqlexp);
		}
		else //if the item is  nonperishable, add to nonperi
		{
			//add record to the nonperi table
			$sql02a = "INSERT INTO itrmc_db01.nonperi (stockid, bal, purchase_date, createdby, createdon)
											  VALUES ('$stockid', '$initbal', '$currdate', '$userid', '$currdate')";
			$mysql02a = $conn->query($sql02a);
		}
		
		echo '<script type="text/javascript">'; 
		echo 'alert("The new item has been successfully added on the inventory.\\n Thank you.");'; 
		echo 'window.location.href = "additem.php";';
		echo '</script>';
	}
	else
	{
		//add record to the otherstocks table
		$sql01 = "INSERT INTO itrmc_db01.othstocks (item_name, `desc`, category, purchase_price, brand, unit, s_status, createdby, createdon, rlvl, remarks) 
										 VALUES ('$itemname', '$itemdesc', '$cat', '$purprice', '$brand', '$unit', 'Active', '$userid', '$currdate', '$rlvl', '$remarks')";
		$mysql01 = $conn->query($sql01);
		$stockid = $conn->insert_id;

		//add record to the bal_log table
		$sql03 = "INSERT INTO itrmc_db01.bal_log (stockid, qtyn, dte_credeb, addsub, purprice, balafter, createdby, createdon)
										  VALUES ('$stockid', '$initbal', '$dateonly', 'A', '$purprice', '$initbal', '$userid', '$currdate')";
		$mysql03 = $conn->query($sql03);
		$logid = $conn->insert_id;

		//if the item is perishable,add to peri
		if ($exp != '')
		{			
			//add record to the peri table
			$sql02 = "INSERT INTO itrmc_db01.peri (stockid, bal, purchase_date, createdby, createdon, exp_date)
											  VALUES ('$stockid', '$initbal', '$currdate', '$userid', '$currdate', '$exp')";
			$mysql02 = $conn->query($sql02);

			$sqlexp = "INSERT INTO itrmc_db01.expire (type, stockid, logid, expdte)
												values ('O', '$stockid', '$logid', '$exp')";
			$mysqlexp = $conn->query($sqlexp);

		}
		else //if the item is  nonperishable, add to nonperi
		{
			//add record to the nonperi table
			$sql02a = "INSERT INTO itrmc_db01.nonperi (stockid, bal, purchase_date, createdby, createdon)
											  VALUES ('$stockid', '$initbal', '$currdate', '$userid', '$currdate')";
			$mysql02a = $conn->query($sql02a);
		}

		
		
		echo '<script type="text/javascript">'; 
		echo 'alert("The new item has been successfully added on the inventory.\\n Thank you.");'; 
		echo 'window.location.href = "additem.php";';
		echo '</script>';
	}
}

