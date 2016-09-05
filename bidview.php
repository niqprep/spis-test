<?php 
session_start();
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';
if (!isset($_GET['bidid']))
{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: admin.php");
} 
else
{
	$bidid = $_GET['bidid'];
}

$userid = $_SESSION['userid'];
$utype = $_SESSION['u_type'];


//get bid details
$qryn = "SELECT  * from bidding where bid_id = '$bidid' ";
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
		}
	}

//get suppliers
$qryn = "SELECT  bidsupp.id, bidsupp.bid_id, bidsupp.remarks, bidsupp.status, supplier.name  
		from bidsupp left outer join supplier on bidsupp.supp_id = supplier.id
		where bid_id = '$bidid' order by supplier.name ";
$mysqln = $conn->query($qryn);

$suppctr = 0;
$bidsupp_id = array();
$bid_id = array();
$rem = array();
$stat = array();
$name = array();

if ($mysqln->num_rows > 0)	
{
while($rown = $mysqln->fetch_assoc())	
	{
	$bidsupp_id[] = $rown['id'];
	$bid_id[] = $rown['bid_id'];
	$rem[] = $rown['remarks'];
	if ($rown['status'] == '1') 
	{
		$stat[] = 'Active';
	}
	else
	{
		$stat[] = 'Inactive';
	}
	
	$name[] = $rown['name'];
	$suppctr++;	
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
				echo '<h2><a href="" onClick="history.go(-1);">Back to list</a> > Supplier\'s list for '.$biddte.' (<i style="color:red;">'.$descr.'</i>)</h2>';
				echo '<br><a href="addbidsupp.php?bidid='.$bidid.'" target="_top"> Click here to add suppliers for this bidding <a/>';
				echo '<a id="title" href="uploadbidsupp.php" target="_top">Upload supplier\'s list for this bid </a>';
				echo '<table class="tblbid">
						<tr>
							<th >Bid-Supp ID</th>
							<th >Supplier</th>
							
							<th >Remarks</th>
							<th >Status</th>
							<th>Actions</th>
						</tr>	';	
				echo '</table>';
				echo '<table class="tblbid">';
						for ($i=0; $i < $suppctr; $i++)
						{ 
							echo '<tr ';
							if ($i % 2 != 0) 
							{
								echo 'id=trblue';
							}
							echo '>
									<td >'.$bidsupp_id[$i].'</td>
									<td >'.$name[$i].'</td>
									<td>'.$rem[$i].'</td>
									<td>'.$stat[$i].'</td>
									<td><a href="bidsupitemvw.php?bidsuppid='.$bidsupp_id[$i].'" title="View" target="_self"> <img src="images\icons\view3.png" id="utils" ></a>
										<a href="bidsupitemedit.php?bidsuppid='.$bidsupp_id[$i].'" title="Edit" target="_self"> <img src="images\icons\edit.png" id="utils" ></a>
									</td>
							</tr>';
						}
						
				echo '</table>';
			echo '</div>';
		?>
	</body>
</html>