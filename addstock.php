<?php

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "admin";
$userid = $_SESSION['userid'];

if (!isset($_POST['cat'])) 
{
	header ("location: selcat.php");
}
else
{
	$cat = $_POST['cat'];	
}

if (($cat == 'HK') OR ($cat == 'OS')) 
{
	//query items list
	$qry = "SELECT * FROM itrmc_db01.stocks 
			where stocks.s_status = '1' and (stocks.category = '$cat')
			order by stocks.item_name asc, stocks.desc asc";
}
else
{	
	//query items list
	$qry = "SELECT * FROM itrmc_db01.othstocks
			where othstocks.s_status = '1' and (othstocks.category = '$cat')
			order by othstocks.item_name asc, othstocks.desc asc";
}
$stockid = array();
$item = array();
$desc = array();
$brand = array();
$unit = array();
$ctr = 0;
$result = $conn-> query($qry);
if ($result-> num_rows > 0)
{
	while ($row = $result -> fetch_assoc()) 
	{
		$stockid[] = $row['id'];
		$item[] = ucwords(strtolower($row['item_name']));
		$desc[] = $row['desc'];
		$unit[] = $row['unit'];
		$ctr++;
	}
}
else
{
	echo '<script type="text/javascript">'; 
	echo 'alert("There are no items in the inventory yet.\\n Thank you!");'; 
	echo 'window.location.href = "selcat.php";';
	echo '</script>';
}

//query supplier's list
$qrysupp = "SELECT * FROM itrmc_db01.supplier";
$suppid = array();
$supp = array();
$ctrsupp = 0;
$resultsupp = $conn-> query($qrysupp);
if ($resultsupp-> num_rows > 0)
{
	while ($row01 = $resultsupp -> fetch_assoc()) 
	{
		$suppid[] = $row01['id'];
		$supp[] = ucwords(strtolower($row01['name']));
		$ctrsupp++;
	}
}


$currdate = Date("Y-m-d");


echo '<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>SPIS - Add Stock</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
	</head>
<body>
<div id="wholepage">
';		
			include 'header.php';
echo '<div id="mbody">
			<h2> Add Stock </h2>
			<form name="addstock" method="POST" action="addstock_process.php"> 
			<input type="hidden" name="catx" value="'.$cat.'" />
				<table id="addstock">
					<tr>
						<td><label for="item">Select Item <strong>*</strong></label></td>
						<td><select name="item" required autofocus required autofocus>';
								
								for ($i=0; $i < $ctr; $i++)
								{ 
									if (isset($brand[$i])) {
										echo '<option value="'.$stockid[$i].'">'.$item[$i].', '.$desc[$i].' ('.$brand[$i].', '.$unit[$i].')</option>';
									}
									else
									{
										echo '<option value="'.$stockid[$i].'">'.$item[$i].', '.$desc[$i].' ('.$unit[$i].')</option>';
									}
									
								}  
								  
								  
							echo '</select>
						</td>
					</tr>
					
					<tr>
						<td><label for="price">Purchased Price <strong>*</strong></label></td>
						<td><input type="number" name="price" min="1" step="any" required></td>
					</tr>
					
					<tr>
						<td><label for="qty">Quantity <strong>*</strong></label></td>
						<td><input type="number" step="1" name="qty" required></td>
					</tr>

					<tr>
						<td><label for="pono">PO No. <strong>*</strong></label></td>
						<td><input type="text" name="pono" required></td>
					</tr>';
					
					echo '
					<tr>
						<td><label for="pono">PO date <strong>*</strong></label></td>
						<td><input type="date" name="podte" max="'.$currdate.'" required></td>
					</tr>
					<tr>
						<td><label for="invno">Invoice No. <strong>*</strong></label></td>
						<td><input type="text" name="invoice" required></td>
					</tr>
					<tr>
						<td><label for="invdte">Invoice date <strong>*</strong></label></td>
						<td><input type="date" name="invdte"  max="'.$currdate.'" required></td>
					</tr>
					<tr>
						<td><label for="risdate">Delivery date <strong>*</strong></label></td>
						<td><input type="date" name="deldate" max="'.$currdate.'" value="'.$currdate.'" readonly></td>
					</tr>';

					if ($cat == 'DM')
					{
						echo '
							<tr>
								<td><label for="exp">Expiration Date <strong>*</strong> </label></td>
								<td><input type="date" name="exp" min="'.$currdate.'" required ></td>
							</tr>';
					}
					else
					{
						echo '
							<tr>
								<td><label for="exp">Expiration Date <i>(if any)</i> </label></td>
								<td><input type="date" name="exp" min="'.$currdate.'" ></td>
							</tr>';
					}

					echo '
					<tr>
						<td><label for="supp">Supplier <strong>*</strong></label></td>
						<td><select name="supp" >';
							for ($x=0; $x < $ctrsupp; $x++)
								{ 
									echo '<option value="'.$suppid[$x].'">'.$supp[$x].'</option>';
								}  

							echo '</select>
						</td>
					</tr>
					<tr>
						<td><label for="Remarks">Remarks</label></td>
						<td><input type="text" name="remarks" placeholder="e.g. DBM, Purchased, etc" ></td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit">
						</td>
					</tr>
				</table>
			</form>
	  </div>';	
			include 'footer.php';
?>

</div>

<script src="js/angular.min.js"></script>									

</body>
</html> 
