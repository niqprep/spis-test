<?php

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	}

include 'database/dbconnect.php';
$_SESSION['currentpage'] = "view";
$userid = $_SESSION['userid'];	


//check if user has selected a stock 
//then get the stock's id
if(isset($_POST['std']))
{
	//sanitize data from user
	$itemname = strip_tags(trim($_POST['nw_itemname']));
	$itemdesc = strip_tags(trim($_POST['nw_itemdesc']));
	$unit = strip_tags(trim($_POST['nw_unit']));
	$brand = strip_tags(trim($_POST['nw_brand']));
	$remarks = strip_tags(trim($_POST['nw_remarks']));
	
	if ( (empty($itemname)) OR (empty($unit)) )
	{
		echo '<script type="text/javascript">'; 
		echo 'alert("Please enter a valid value for itemn\'s name or unit. \\n Thank you.");'; 
		echo 'history.go(-1);';
		echo '</script>';
	}

	$stockid = $_POST['std'];
	$cat = $_POST['nw_cat'];
	$catold = $_POST['cat'];

	//format data properly
	$item = ucwords(strtolower($itemname));
	$desc = ucfirst(strtolower($itemdesc));
	$brand = ucwords(strtolower($brand));
	
	$remarks = ucfirst($remarks);
}
else
{
	echo '<script type="text/javascript">'; 
   	echo 'alert("Category or Item\'s information is incorrect.\\n Please try again.");'; 
    echo 'window.location.href = "selcat3.php";';
    echo '</script>';
}

//escape special characters when accessing db
$itemname = mysql_real_escape_string(htmlspecialchars($item));
$itemdesc = mysql_real_escape_string(htmlspecialchars($desc));
$brand = mysql_real_escape_string(htmlspecialchars($brand));
$unit = mysql_real_escape_string( htmlspecialchars($unit));
$remarks = mysql_real_escape_string($remarks);
$purprice = $_POST['nw_purprice'];
$exp = trim($_POST['nw_exp']);
$rlvl = $_POST['nw_rlvl'];
$stat = mysql_real_escape_string($_POST['nw_status']);
$cron = $_POST['cron'];
$crby = $_POST['crby'];

//get the current date and time
$currdate = Date("Y-m-d h:i:s A");

//update tables with the new data

####################################################
########  scenario: from HK/OS to oth vv. ??
####################################################

if ($catold == "HK" OR $catold == "OS")
{
	if ($cat == "HK" OR $cat == "OS")
	{
		$sqlstocks = "UPDATE stocks set item_name = '$itemname' ,
					 `desc` = '$itemdesc',
					  category = '$cat',
					  purchase_price = '$purprice',
					  brand = '$brand', 
					  unit = '$unit', 
					  s_status = '$stat',
					  rlvl = '$rlvl',
					  remarks = '$remarks', 
					  modifiedby = '$userid', 
					  modifiedon = '$currdate'
				where id = $stockid";
		if ($conn->query($sqlstocks) === TRUE)
		{
	    	
	    	echo '<script type="text/javascript">'; 
		   	echo 'alert("Record updated successfully.\\n Thank you.");'; 
		    echo 'window.location.href = "bincard.php?cat='.$catold.'";';
		    echo '</script>';
			
		} 
		else 
		{
		    $msg = "Error updating record: " . $conn->error ."\n Please try again.";
		    /*echo $msg;*/
		    echo '<script type="text/javascript">'; 
   			echo 'alert("Error updating record.\\n Please try again.");'; 
		    echo 'history.go(-1);';
		    echo '</script>';	
		}

	
	}
	else 
	{
		//new category is != HK/OS -- 
		//insert a new row on the othstocks tbl, but same stock id
		$sqlstocks = "INSERT INTO othstocks (id, item_name, `desc`, category, purchase_price, brand, unit, s_status, rlvl, modifiedby, modifiedon, createdon, createdby,  remarks) 
			VALUES ('$stockid', '$itemname', '$itemdesc', '$cat', '$purprice', '$brand', '$unit', '$stat', '$rlvl', '$userid','$currdate', '$cron', '$crby', '$remarks')";
		//drop the old row on the stocks tbl
			/*"DELETE FROM stocks where id = '$stockid'"	*/
		//get the id of the last updated row?
	
	}
	
}
else //if catold != HK/OS
{
	if ($cat != "HK" or $cat != "OS")
	{
		//update othstocks tbl
		$sqlstocks = "UPDATE othstocks set item_name = '$itemname' ,
					 `desc` = '$itemdesc',
					  category = '$cat',
					  purchase_price = '$purprice',
					  brand = '$brand', 
					  unit = '$unit', 
					  s_status = '$stat',
					  rlvl = '$rlvl',
					  remarks = '$remarks', 
					  modifiedby = '$userid', 
					  modifiedon = '$currdate'
		where id = $stockid";
	}
	/*else //new category is HK/OS
		//copy row from othstocks to stocks table
		//delete row from othstocks*/


}




	/*//update expiration date 
	$sqlexp1 = "SELECT * from expire inner join bal_log on expire.logid = bal_log.log_id where expire.stockid = '$stockid' order by expid desc limit 1";
	$res = $conn->query($sqlexp1);
	if ($res -> num_rows > 0)
	{
		while ($rowe = $res->fetch_assoc())
		{
			$expid = $rowe['expid'];
			$logid = $rowe['logid'];
			$expdte = $rowe['expdte'];

		}

		$sqlexp = "UPDATE expire set expdte = '$exp'
					where stockid = '$stockid' order by expid desc limit 1";
	}
	else
	{

	}
		*/



