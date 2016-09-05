<?php 
session_start();
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("top.window.location: logform.php");
	} 
	
include 'database/dbconnect.php';
if (!isset($_GET['bidsuppid']))
{
	//print "<script>alert('You Failed to Log In')</script>";
	//header ("location: admin.php");
	echo "<script>";
	echo "top.window.location = 'admin.php';";
	echo "</script>";
} 
else
{
	$bidsuppid = $_GET['bidsuppid'];
}

$userid = $_SESSION['userid'];
$utype = $_SESSION['u_type'];


//get bid details
$qryn = "SELECT  * from bidding left outer join bidsupp on bidsupp.bid_id = bidding.bid_id 
								left outer join supplier on bidsupp.supp_id = supplier.id  where bidsupp.id = '$bidsuppid' ";
$mysqln = $conn->query($qryn);

if ($mysqln->num_rows > 0)	
	{
	while($rown = $mysqln->fetch_assoc())	
		{
			$biddte = new DateTime($rown['biddingdte']);
			$biddte = $biddte->format('F d, Y');

			$descr = $rown['description'];
			$stat = $rown['bid_stat'];
			$remarks = $rown['biddingrem'];
			$supplier = $rown['name'];
		}
	}

//array
$descrip = array();
$bsiid = array();
$uprice = array();
$cat = array();
$item = array();
$brand = array();
$unit = array();
$ctr = 0;
//get item details
$qryitem = "SELECT othstocks.`desc` as descrip, bsi_id, uprice, cat, item_name, brand, unit from bidsuppitem left outer join othstocks on itemid = othstocks.id
			where bidsuppitem.biddsupp_id = $bidsuppid
            union all 
			SELECT stocks.`desc` as descrip, bsi_id, uprice, cat, item_name, brand, unit from bidsuppitem left outer join stocks on itemid = stocks.id
			where bidsuppitem.biddsupp_id = $bidsuppid";
$mysqlitem = $conn->query($qryitem);

if ($mysqlitem->num_rows > 0)	
	{
	while($rowi = $mysqlitem->fetch_assoc())	
		{
			if ($rowi['item_name'] != '')
			{
				$descrip[] = $rowi['descrip'];
				$bsiid[] = $rowi['bsi_id'];
				$uprice[] = $rowi['uprice'];
				$cat[] = $rowi['cat'];
				$item[] = $rowi['item_name'];
				$brand[] = $rowi['brand'];
				$unit[] = $rowi['unit'];
				$ctr++;
			}
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
				echo '<h2><a href="admin.php" target="_top">Back to Bidding List </a> > <a href="" onClick="history.go(-1);">Back to Supplier list</a> > Items for this bid</h2>';
				echo $biddte.' <br> <b>'.$descr.'</b><br> '.$supplier.' <br><br><a href="addbidsuppitem.php?bidsuppid='.$bidsuppid.'" target="_top"> Click here to add items for this supplier\'s bid. <a/>';
				echo '<a id="title" href="uploadbidsuppitem.php" target="_top">Upload item\'s list for this bid </a>';
				echo '<table class="tblbid">
						<tr>
							<th >Item Name</th>
							<th >Description</th>
							<th >Unit</th>
							<th>Unit Price</th>
							<th>Total</th>
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
									<td >'.$bsiid[$i].' - '.$item[$i].'</td>
									<td >'.$descrip[$i].'</td>
									<td >'.$unit[$i].'</td>
									<td>Php '.$uprice[$i].'</td>
									<td>Status</td>
									<td><a href="#.php?bidid='.$bidsuppid.'" title="View" target="_self"> <img src="images\icons\view3.png" id="utils" ></a>
										<a href="#?bidid='.$bidsuppid.'" title="Edit" target="_self"> <img src="images\icons\edit.png" id="utils" ></a>
									</td>
							</tr>';
						}
						
				echo '</table>';
			echo '</div>';
		?>
	</body>
</html>