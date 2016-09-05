<?php

session_start();
if (!isset($_SESSION['username'])) //check user
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	}
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "view";
//check if user has selected a stock 
//then get the stock's id
if(isset($_GET['std']) && isset($_GET['cat']))
{
	$stockid = $_GET['std'];
	$cat = $_GET['cat'];
}
else
{
	header("location: bincard.php");
}
$c1 = array("HK","OS"); //get item details from db
$c2 = array("MS", "DM", "OE", "CS", "FF", "ITE", "SP", "LS", "HE", "Oth", "LIB", "CHE", "COME", "CHESI");
switch (true) 
{
	case in_array($cat, $c1):
		$sql = "SELECT 	 *,
						 stocks.createdby as stocks_crby,
						 stocks.createdon as stocks_cron,
						 stocks.modifiedon as stocks_modon
				FROM bal_log
				inner join stocks on bal_log.stockid = stocks.id 
				inner join cat on stocks.category = cat.catcode 
				left outer join user on stocks.createdby = user.id
				where stocks.id = $stockid
				order by bal_log.createdon desc limit 1";
		$ind = "a";
	break;
	case in_array($cat, $c2):
		$sql = "SELECT *,
						othstocks.createdby as stocks_crby,
						othstocks.createdon as stocks_cron,
						othstocks.modifiedon as stocks_modon
				FROM bal_log 
				inner join othstocks on bal_log.stockid = othstocks.id
				inner join cat on othstocks.category = cat.catcode 
				inner join user on othstocks.createdby = user.id
				where othstocks.id = $stockid
				order by bal_log.createdon desc limit 1";
		$ind = "b";
	break;
	default:
		echo '<script type="text/javascript">'; 
   		echo 'alert("Category or Item\'s information is incorrect.\\n Please try again.");'; 
    	echo 'window.location.href = "selcat3.php";';
     	echo '</script>';
	break;
}
/*if ($cat == 'HK' or $cat == 'OS')
{
	$sql = "SELECT * FROM stocks 
	inner join cat on stocks.category = cat.catcode 
	inner join bal_log on stocks.id = bal_log.stockid
	where stocks.id = $stockid
	order by bal_log.createdon desc limit 1";
}
else
{
	$sql = "SELECT * FROM othstocks 
	inner join cat on othstocks.category = cat.catcode 
	inner join bal_log on othstocks.id = bal_log.stockid
	where othstocks.id = $stockid
	order by bal_log.createdon desc limit 1";
}
*/

$qry = $conn->query($sql);
if ($qry-> num_rows > 0)
{
	while ($row = $qry -> fetch_assoc())
	{
		//get item's details and assign them to variables
		$item =  ucwords(strtolower($row['item_name']));
		$descitem = ucfirst(strtolower($row['desc']));
		$cat = $row['catcode'];
		$price = $row['purchase_price'];
		$brand = ucfirst($row['brand']);
		$unit = strtolower($row['unit']);
		$stat = $row['s_status'];
		$rlvl = $row['rlvl'];
		$remarks = $row['remarks'];
		
		$creaton = $row['stocks_cron'];
		//$modby = $row['modby'];
		$creatby = $row['uname'];
		$modon = $row['stocks_modon'];
		$logid = $row['log_id'];
		$balafter = $row['balafter'];

		$sqllog = "SELECT * from expire where expire.stockid = '$stockid' order by expid desc limit 1";
		$qrylog = $conn -> query($sqllog);

		if ($qrylog -> num_rows > 0)
		{
			while ($row02 = $qrylog -> fetch_assoc())
			{
				$exp = $row02['expdte'];
			}
		}
		else
		{
			$exp = '';
		}


	}
}
else
{
	echo '<script type="text/javascript">'; 
   	echo 'alert("Category or Item\'s information is incorrect.\\n Please try again.");'; 
    echo 'window.location.href = "selcat3.php";';
    echo '</script>';
}

$sqlmod = "SELECT *, user.uname as modby
        	FROM user 
			inner join stocks on user.id = stocks.modifiedby
			where stocks.id = $stockid";
$qrymod = $conn->query($sqlmod);
if ($qrymod-> num_rows > 0)
{
	while ($rowm = $qrymod -> fetch_assoc())
	{
		$modby = $rowm['modby'];
	}
}

$code = array();
$desc = array();
$ctr = 0;
$sqlcat = "SELECT * from cat where stat = 'Active' order by catdesc asc";
$result = $conn->query($sqlcat);
if ($result -> num_rows > 0) 
{
	while($row01 = $result-> fetch_assoc())
	{
		$code[] = $row01['catcode'];
		$desc[] = $row01['catdesc']; 
		$ctr++;
	}
}



?>


<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
		
	</head>

<body >
<?php
echo '<div id="wholepage">
';		

			include 'header.php';

echo '<div id="mbody">
		<h2><a href="bincard.php?cat='.$cat.'" onClick="history.go(-1);">View Item</a> > Edit Item</h2>';
?>

	 <form name="edititem" method="POST" action="edititem_proc.php">
<?php		echo '		<input type="hidden" name="std" value="'.$stockid.'" />
						<input type="hidden" name="cron" value="'.$creaton.'" 
						<input type="hidden" name="crby" value="'.$creatby.'" 
						

 				<table id="addstock">
 				<table id="addstock">
					<tr class="head">
						<td> </td>
						<td>Old value </td>
						<td>New value </td>

					</tr>
					<tr>
						<td><label for="item" >Item Name <strong>*</strong></label></td>
						<td>
							<input type="text" name="itemname" value="'.$item.'" readonly>
						</td>
						<td>
							<input type="text" name="nw_itemname" value="'.$item.'" autofocus required>
						</td>
					</tr>
					
					<tr>
						<td><label for="desc">Item Description </label></td>
						<td>
							<input type="text" name="itemdesc" value="'.$descitem.'" readonly >
						</td>
						<td>
							<input type="text" name="nw_itemdesc" value="'.$descitem.'" >
						</td>
					</tr>
					
					<tr>
						<td><label for="cat">Category <strong>*</strong></label></td>
						<td><select name="cat" readonly>';
								for ($x=0; $x < $ctr; $x++) 
								{ 
									if ($code[$x] == $cat) 
									{
										echo '<option value="'.$code[$x].'" selected> '.$desc[$x].' </option>';
									}
									
								}


					  echo '</select>
						</td>
						<td><select name="nw_cat" >';
								for ($x=0; $x < $ctr; $x++) 
								{ 
									if ($code[$x] == $cat) 
									{
										echo '<option value="'.$code[$x].'" selected> '.$desc[$x].' </option>';
									}
									else
									{
										echo '<option value="'.$code[$x].'"> '.$desc[$x].' </option>';
									}
								}


					  echo '</select>
						</td>
					</tr>
					<tr>
						<td><label for="brand">Brand <i> (if any)</i></label></td>
						<td><input type="text" name="brand" value="'.$brand.'" readonly></td>
						<td><input type="text" name="nw_brand" value="'.$brand.'"></td>
					</tr>
					<tr>
						<td><label for="unit">Unit <strong>*</strong></label></td>
						<td><input type="text" name="unit" value="'.$unit.'" readonly></td>
						<td><input type="text" name="nw_unit" value="'.$unit.'" required></td>
					</tr>
					<!-- <tr>
						<td><label for="availbal">Available Balance <strong>*</strong></label></td>
						<td><input type="number" name="availbal" min="0" value="'.$balafter.'" readonly></td>
						<td> <input type="number" name="availbal" min="0" value="'.$balafter.'" readonly></td>
					</tr> -->
					<tr>
						<td><label for="purprice">Purchased Price <strong>*</strong></label></td>
						<td><input type="number" step="any" name="purprice" min="0" value="'.$price.'" readonly></td>
						<td><input type="number" step="any" name="nw_purprice" min="0" value="'.$price.'" required></td>

					</tr>
					<tr>
						<td><label for="exp">Expiration Date <i>(if any)</i> </label></td>
						<td><input type="date" name="exp" min="'.$currdate.'" value="'.$exp.'" readonly></td>
						<td><input type="date" name="nw_exp" min="'.$currdate.'" value="'.$exp.'"></td>

					</tr>
					<tr>
						<td><label for="rlvl">Reorder Level <strong>*</strong></label></td>
						<td><input type="number" name="rlvl" min="0" value="'.$rlvl.'" readonly></td>
						<td><input type="number" name="nw_rlvl" min="0" value="'.$rlvl.'" required></td>
					</tr>
					<tr>
						<td><label for="Status">Status</label></td>
						<td>	<select name="status" >';

									if ($stat == "Active") 
									{
										echo '<option value="Active" selected>Active </option>';
									}
									else
									{
										echo '<option value="Inactive" selected> Inactive </option>';
									}

						  echo '</select>
						</td>
						<td>	<select name="nw_status">';

									if ($stat == "Active") 
									{
										echo '<option value="Active" selected>Active </option>
											<option value="Inactive"> Inactive </option>';
									}
									else
									{
										echo '<option value="Active">Active </option>
											<option value="Inactive" selected> Inactive </option>';
									}

						  echo '</select>
						 </td>
					</tr>
					<tr>
						<td><label for="Remarks">Remarks</label></td>
						<td><input type="text" name="remarks" value="'.$remarks.'" readonly></td>
						<td><input type="text" name="nw_remarks" value="'.$remarks.'"></td>
					</tr>
					<tr>
						<td colspan="3">Created by '.$creatby.' on '.$creaton.'</td>
					</tr>
					<tr>
						<td colspan="3">Last modified by '.$modby.' on '.$modon.'</td>
					</tr>
					<tr>
						<td >
						</td>
						<td colspan="2">';?>

							<button onClick="history.go(-1);">Cancel</button>
							<input type="submit" onClick="return confirm('Do you really want to modify the item?');">
						</td>
					</tr>
				</table>
			</form>
					

	</div>
	
		
<?php		
			include 'footer.php';
?>

</div>

<script src="js/angular.min.js"></script>									

</body>
</html> 