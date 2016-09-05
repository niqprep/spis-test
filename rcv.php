<?php session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "po";
if((!isset($_GET['poid'])) AND (!isset($_POST['po_no'])))
{
	header ("location: rcvpo.php");
}
if (isset($_GET['poid']))
{	
	$poid = $_GET['poid'];
	$qry = "SELECT * from itrmc_db01.purchase_order where purchase_order.id='$poid' AND purchase_order.status='Waiting for Delivery'";
}
if(isset($_POST['po_no']))
{
	$po_no = $_POST['po_no'];
	$qry = "SELECT * from itrmc_db01.purchase_order where purchase_order.po_number = '$po_no' AND purchase_order.status='Waiting for Delivery'";
}
$result = $conn->query($qry);

if($result->num_rows <= 0)
{
	echo '<script type="text/javascript">'; 
	echo 'alert("No records found or the PO has already been delivered.\\nTry again.");'; 
	echo 'history.go(-1);';
	echo '</script>';
}
else
{
	while ($row = $result -> fetch_assoc()) 
	{
		$poid = $row['id'];
		$po_no = $row['po_number'];
		$pterm = $row['pterm'];
		$cat = $row['category'];
		$status = $row['status'];
		$mode = $row['mode'];
		$dterm = $row['dterm'];
		$delby = $row['conformeby'];	
	}

	//get the items list
	$qrypoitem = "SELECT * FROM itrmc_db01.purchase_order
					left join itrmc_db01.po_poitems on purchase_order.id = po_poitems.po_id
					left join itrmc_db01.po_item on po_poitems.poitem_id = po_item.id
					where purchase_order.id = '$poid' and po_item.status = 'Active' order by po_poitems.poitem_id asc";
		
	$mysqlb = $conn->query($qrypoitem);	
	$poitemdesc=array();	
	$poitemunit=array();
	$qty=array();
	$unitc= array();
	$ctritem=0;
	if ($mysqlb->num_rows > 0)					
	{						
		while($rowb = $mysqlb->fetch_assoc())
		{
			$poitemunit[$ctritem]= $rowb['unit'];
			$poitemdesc[$ctritem]= $rowb['itemdesc'];
			$qty[$ctritem]= $rowb['qty'];
			$unitc[$ctritem]= $rowb['unit_cost'];
			$ctritem++;
		}	
	}

}

echo '
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
			
	</head>
<body>
<div id="wholepage">
';		

			include 'header.php';
		
		echo '<div id="mbody">
				<div id="submenu">
				</div>
			
			<div id="mc_rcv">
				<h2> <a href="rcvpo.php"> Receive Delivery </a>  > PO # <strong>'.$po_no .'</strong></h2>
				Category: '.$cat.'
			</div>
		
		<form id="rcv" name="rcv" method="post" action="#" >
		<table id="record2">
			<tr id="heading2"> 
				<td> # </td>
				<td colspan="4">Description		</td>
				<td>Qty		</td>
				<td >Qty Delivered	</td>
				<td >Unit		</td>
				<td >Unit Cost		</td>
				
			</tr>
		</table>

		<div class="container">
			 <table id="record">';
			 	for ($i=0; $i < $ctritem; $i++) 
			 	{ 
			 		echo '
			 		<tr id="heading2"> 
						<td>'.$i++.' </td>
						<td colspan="4">'.$poitemdesc[$i].'</td>
						<td>'.$qty[$i].'</td>
						<td >Qty Delivered	</td>
						<td >'.$poitemunit[$i].'</td>
						<td >'.$unitc[$i].'	</td>
					</tr>';
			 	}
			 	
		echo 
			'</table>
		</div>
		<div class="buttons">

		</div>
</div>
		';
		
		
			include 'footer.php';
		
	echo '</div>
<script src="js/angular.min.js"></script>									

</body>
</html> 
	';

?>