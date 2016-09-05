<?php 
session_start();
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("top.window.location: logform.php");
	} 
	
include 'database/dbconnect.php';
include 'functions.php';
if (!isset($_GET['ppmpid']))
{
	//print "<script>alert('You Failed to Log In')</script>";
	//header ("location: admin.php");
	echo "<script>";
	echo "top.window.location = 'ppmp.php';";
	echo "</script>";
} 
else
{
	$ppmpid = $_GET['ppmpid'];
	$section = $_GET['nme'];
	$year = $_GET['yr'];

}

$userid = $_SESSION['userid'];
$utype = $_SESSION['u_type'];



//get ppmp details
$qryn = "SELECT  
		othstocks.item_name,
		othstocks.`desc` as desci,
		othstocks.unit,
		othstocks.purchase_price,
		ppmp_items.qty,
		ROUND((othstocks.purchase_price * ppmp_items.qty ), 2) AS totalamt,
		ppmp_items.id, 
		ppmp_items.srcfund,
		ppmp_items.procmeth, 
		ppmp_items.stat 
		from othstocks left outer join ppmp_items on ppmp_items.itemid = othstocks.id
								left outer join ppmp on ppmp_items.ppmpid = ppmp.ppmpid									
									left outer join section on ppmp.sectionid = section.sect_id
		                            left outer join ppmpyr on ppmp.ppmpyrid = ppmpyr.id
		where ppmp.ppmpid = '$ppmpid' and ppmp_items.stat = '1' 

		union all

		SELECT  		
		stocks.item_name,
		stocks.`desc` as desci,
		stocks.unit,
		stocks.purchase_price,
		ppmp_items.qty,
		ROUND((stocks.purchase_price * ppmp_items.qty ), 2) AS totalamt,
		ppmp_items.id, 
		ppmp_items.srcfund,
		ppmp_items.procmeth, 
		ppmp_items.stat 
		from stocks left outer join ppmp_items on ppmp_items.itemid = stocks.id
								left outer join ppmp on ppmp_items.ppmpid = ppmp.ppmpid									
									left outer join section on ppmp.sectionid = section.sect_id
		                            left outer join ppmpyr on ppmp.ppmpyrid = ppmpyr.id	                            
		where ppmp.ppmpid = '$ppmpid' and ppmp_items.stat = '1'";

$ppmpitemid = array();
$item = array();
$desci = array();
$unit = array();
$price = array();
$qty = array();
$totalamt = array();
$srcfund = array();
$procmeth = array();
$stat = array();
$ctr=0;
$mysqln = $conn->query($qryn);
if ($mysqln->num_rows > 0)	
	{
	while($rown = $mysqln->fetch_assoc())	
		{
			
			$ppmpitemid[] = $rown['id'];
			$item[] = $rown['item_name'];
			$desci[] = $rown['desci'];
			$unit[] = $rown['unit'];
			$price[] = $rown['purchase_price'];
			$qty[] = $rown['qty'];
			$totalamt[] = $rown['totalamt'];
			$srcfund[] = $rown['srcfund'];
			$procmeth[] = $rown['procmeth'];

			if ($rown['stat'] == '1') 
			{
				$stat[] = 'Active';
			}
			else
			{
				$stat[] = 'Inactive';
			}
			
			$ctr++;
		}
	}





 
?>

<html  style="overflow-x: hidden;">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/styletab.css" rel="stylesheet" type="text/css" />
		<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php
			echo '<div id="backlnk">';
				echo '<h2><a href="ppmp.php" target="_top">Back to Fiscal Year List </a> > <a href="" onClick="history.go(-1);">Back to Sections list</a> >  '.$section.' PPMP</h2>';
				echo $section.' PPMP for FY '.$year.'</b><br> <br><a href="addppmpitem.php?ppmpid='.$ppmpid.'&sect='.cleanthis($section).'&yr='.$year.'" target="_top"> Click here to add items for this PPMP <a/>';
				echo '<a id="title" href="#.php" target="_top">Upload item\'s list for this PPMP </a>';
				echo '<table class="tblbid">
						<tr>
							<th >Item Name</th>
							<th >Description</th>
							<th >Unit</th>
							<th >Qty</th>
							<th>Est Unit Cost</th>
							<th>Total Amount</th>
							<th>Source of Funding</th>
							<th>Procurement Method</th>
							<th>Actions</th>
						</tr>	';	
				echo '</table>';
				echo '<table class="tblbid">';
						for ($i=0; $i < $ctr; $i++)
						{ 
							
							echo '<tr ';
							if ($i % 2 != 0) 
							{
								echo 'id=trblue';
							}
							echo '>
									<td >'.$ppmpitemid[$i].' -'.$item[$i].' </td>
									<td >'.$desci[$i].'</td>
									<td >'.$unit[$i].'</td>
									<td >'.$qty[$i].'</td>
									<td>Php '.$price[$i].'</td>
									<td>Php '.$totalamt[$i].'</td>
									<td>'.$srcfund[$i].'</td>
									<td>'.$procmeth[$i].'</td>
									<td><a href="#.php?ppmpid='.$ppmpid.'&ppmpitemid='.$ppmpitemid[$i].'" title="View" target="_self"> <img src="images\icons\view3.png" id="utils" ></a>
										<a href="#?ppmpid='.$ppmpid.'&ppmpitemid='.$ppmpitemid[$i].'" title="Edit" target="_self"> <img src="images\icons\edit.png" id="utils" ></a>
									</td>
							</tr>';
						}
						
				echo '</table>';
			echo '</div>';
		?>
	</body>
</html>