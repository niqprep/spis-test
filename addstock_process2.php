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

if(!isset($_POST['item']))
{
	header("location: addstock.php");
}
else
{	
	$pono = $_POST['pono'];
	//assign variables to the post vars
	$stockid = intval($_POST['item']);
	$price = $_POST['price'];
	$qty = $_POST['qty'];
	$inv = $_POST['invoice'];
	$invdte = $_POST['invdte'];
	$deldte = $_POST['deldate'];
	$exp = $_POST['exp'];
	$suppid = $_POST['supp'];
	$remarks = $_POST['remarks'];
	$podte = $_POST['podte'];
	$cat = $_POST['catx'];
	
	//get the current date and time
	$currdate = Date("Y-m-d h:i:s A");
	
	
		
		//check if stock or othstock
		if (($cat == 'OS') OR ($cat == 'HK')) 
		{
			//update purchase price into the stocks table
			$sql04 = "UPDATE itrmc_db01.stocks set purchase_price = '$price' where stocks.id = '$stockid'";
			$mysql04 = $conn->query($sql04);
		}
		else
		{
			//update purchase price into the othstocks table
			$sql04 = "UPDATE itrmc_db01.othstocks set purchase_price = '$price' where othstocks.id = '$stockid'";
			$mysql04 = $conn->query($sql04);
		}

		//check if the stock is perishable or not
		//and get the current bal
		$sqlchk = "SELECT * from itrmc_db01.nonperi where stockid = '$stockid'";
		$mysqlchk = $conn->query($sqlchk);
		//if the stockid belongs to nonperi...
		if ($mysqlchk->num_rows > 0) 
		{
			//get current bal
			while ($rowchk = $mysqlchk->fetch_assoc()) 
			{
				$currbal = $rowchk['bal'];
			}
			
			//add the delivered qty to the current bal
			$newqty = $qty + $currbal;
			//now update nonperi table
			$sqlnperi = "UPDATE itrmc_db01.nonperi 
				set bal = '$newqty', 
					purchase_date = '$deldte',
					modifiedby = '$userid',
					modifiedon = '$currdate'
				where nonperi.stockid = $stockid";
			$mysqlnperi = $conn->query($sqlnperi);
		}
		//else if not, then update peri table
		else if ($mysqlchk->num_rows < 1) 
		{
			//first get the current bal
			$sqlperi = "SELECT * from itrmc_db01.peri where stockid = '$stockid'";
			$mysqlperi = $conn->query($sqlperi);
			if($mysqlperi->num_rows > 0)
			{
				while ($rowperi = $mysqlperi->fetch_assoc()) 
				{
					$currbal = $rowperi['bal'];
				}
				//add the delivered qty to the current bal
				$newqty = $qty + $currbal;
			}
				//now update peri table
			$sqlnper = "UPDATE itrmc_db01.peri 
				set bal = '$newqty', 
					purchase_date = '$deldte',
					exp_date = '$exp',
					modifiedby = '$userid',
					modifiedon = '$currdate'
				where peri.stockid = $stockid";
			$mysqlnper = $conn->query($sqlnper);
		}
		
		//check for the po number duplicate
		$qrypo = "SELECT * FROM itrmc_db01.purchase_order WHERE po_number='$pono'";
		$resultpo = $conn->query($qrypo);
		if ($resultpo->num_rows < 1)
		{
			//add po number into the po tbl
			$sql01 = "INSERT INTO itrmc_db01.purchase_order (po_number, category, status, podate, supplierid, createdby, created, dateofdel)
					VALUES ('$pono', '$cat', '', '$podte', '$suppid', '$userid', '$currdate', '$deldte')";
			$mysql01 = $conn->query($sql01);
		}
		else
		{
			//UPDATE po tbl 
			$sql01 = "UPDATE itrmc_db01.purchase_order
								set category = '$cat',
									podate = '$podte',
									supplierid = '$suppid',
									modifiedby = '$userid',
									modified = '$currdate',
									dateofdel = '$deldte'
								where po_number = $pono";
			$mysql01 = $conn->query($sql01);

		}

		//add a record into the bal_log table
		$sql02 = "INSERT INTO itrmc_db01.bal_log (stockid, qtyn, dte_credeb, addsub, purprice, balafter, createdby, createdon)
				VALUES ('$stockid', '$qty', '$deldte', 'A', '$price', '$newqty', '$userid', '$currdate')";
		$mysql02 = $conn->query($sql02); 
		$id02 = $conn->insert_id;
		
		//add a record into the invoice tbl
		$sql06 = "INSERT INTO itrmc_db01.invoice (invoice, invdte, status, createdby, createdon)
				VALUES ('$inv', '$invdte', '', '$userid', '$currdate')";
		$mysql06 = $conn->query($sql06);

		//add a record into the addbalpo tbl
		$sql03 = "INSERT INTO itrmc_db01.addbalpo (po_no, invoice_id, ballog_id, remarks, createdby, createdon)
				VALUES ('$pono', LAST_INSERT_ID(), '$id02', '$remarks', '$userid', '$currdate')";
		$mysql03 = $conn->query($sql03);

		if (($cat == 'OS') OR ($cat == 'HK')) 
		{
			//add a record into the expire tbl
			$sqlexp = "INSERT INTO itrmc_db01.expire (type, stockid, logid, expdte)
						VALUES ('S', '$stockid', '$id02', '$exp')";
		}
		else
		{
			//add a record into the expire tbl
			$sqlexp = "INSERT INTO itrmc_db01.expire (type, stockid, logid, expdte)
						VALUES ('O', '$stockid', '$id02', '$exp')";
		}
		
		echo '<script type="text/javascript">'; 
		echo 'alert("Stock/s has been successfully added on the inventory.\\n Thank you.");'; 
		echo 'window.location.href = "addstock.php";';
		echo '</script>';
		
}

