<?php
/*********************************************** 
* Script Name : po - bidder* 
* Scripted By : Monique Prepose * 
* Email : nicprep@ymail.com *
* Details: User selects supplier based from the selected bidding(po.php) before he/she can select items(po3.php)
***********************************************/ 
session_start();

//check user
if (!isset($_SESSION['username']))
{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
} 
//check bidid
if (!isset($_GET['bidid']) || !isset($_GET['prid']) )
{
	
	header ("location: po.php");
} 
else
{
	$bidid = $_GET['bidid'];
	$prid = $_GET['prid'];	
}

include 'database/dbconnect.php';
$_SESSION['currentpage'] = "po";


///////////////////////////////get bid details
$qrybid = "SELECT biddingdte, description, biddingrem  FROM bidding where bid_id = '$bidid' and bid_stat = '1'";
$resultbid = $conn->query($qrybid);
if ($resultbid->num_rows > 0)
{
	while ($rowb = $resultbid->fetch_assoc())
	{
		$biddte2 = new DateTime( $rowb["biddingdte"]);
		$biddte2 = $biddte2->format('F d, Y');
		$descript = $rowb["description"];
		$rem = $rowb['biddingrem'];
	}
}


/////////////////////////////QUERY DB FOR CATEGORIES
/*$qrycat = "SELECT * from cat
			where stat = '1'";
$resultcat = $conn->query($qrycat);
$catid = array();
$catcode = array();
$catdesc = array();
$ctrcat = 0;
if ($resultcat->num_rows > 0)
{
	while ($rowcat = $resultcat->fetch_assoc())
	{
		$catid[] = $rowcat['catid'];
		$catcode[] = $rowcat["catcode"];
		$catdesc[] = $rowcat["catdesc"];
		$ctrcat++;
	}
}*/


/////////////////////////////get suppliers
$qryn = "SELECT  bidsupp.id, supplier.name  
		from bidsupp left outer join supplier on bidsupp.supp_id = supplier.id
		where bid_id = '$bidid' and bidsupp.status = '1' order by supplier.name ";
$mysqln = $conn->query($qryn);

$suppctr = 0;
$bidsupp_id = array();
$name = array();

if ($mysqln->num_rows > 0)	
{
while($rown = $mysqln->fetch_assoc())	
	{
	$bidsupp_id[] = $rown['id'];
	
	$name[] = $rown['name'];
	$suppctr++;	
	}
}

$qrypr = "SELECT * from pr where id = '$prid'";
$resultpr = $conn->query($qrypr);
if ($resultpr->num_rows > 0)
{
	while ($rowpr = $resultpr->fetch_assoc())
	{
		$prno = $rowpr['pr_no'];
		$prcat = $rowpr['prcat'];
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script src="js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {	

					var id = '#dialog';
				
					//Get the screen height and width
					var maskHeight = $(document).height();
					var maskWidth = $(window).width();
				
					//Set heigth and width to mask to fill up the whole screen
					$('#mask').css({'width':maskWidth,'height':maskHeight});
					
					//transition effect		
					$('#mask').fadeIn(1000);	
					$('#mask').fadeTo("slow",0.8);	
				
					//Get the window height and width
					var winH = $(window).height();
					var winW = $(window).width();
						  
					//Set the popup window to center
					$(id).css('top',  winH/2-$(id).height()/1);
					$(id).css('left', winW/2-$(id).width()/2);
				
					//transition effect
					$(id).fadeIn(1000); 	
				
			
			});

		</script>
		
		
	</head>
<body>
	<div id="wholepage"">		
		<?php
			include 'header.php';
		
		
			echo '<div id="boxes">
				<div id="dialog" class="window">
				<ul>
				 	<li><a href="index.php" title="Go to Home page">Dashboard</a></li>|
				 	<li><a href="searchpo.php"  title="Manage PO">Manage PO</a></li>|
				 	<li><a href="admin.php"  title="Add bidding date">Add New Bidding</a></li>

				</ul>
					
					<form name="logno" id="rcv" method="post" action="poitemschk.php">
					<input type="hidden" name="prno" value="'.$prno.'"/>
					<input type="hidden" name="prid" value="'.$prid.'"/>
					<input type="hidden" name="catid" value="'.$prcat.'"/>
					<input type="hidden" name="bidid" value="'.$bidid.'"/>
						<table id="potbls2">
									<tr>
										<td>PR No.</td>
										<td>'.$prno.'</td>
										
									</tr>
									<tr>
										<td>Bidding Date</td>
										<td>'.$biddte2.'</td>
										
									</tr>
									<tr>
										<td>Bidding Description</td>
										<td>'.$descript.'</td>
										
									</tr>
									<tr>
										<td>Bidding Remarks</td>
										<td>'.$rem.'</td>
										
									</tr>
									<tr>
										<td>Select Supplier</td>
									</tr> </table>
											<select name="bidsuppid" id="slct" autofocus>';
											for ($i=0; $i < $suppctr; $i++) 
											{ 
												echo '<option value="'.$bidsupp_id[$i].'"> '.$name[$i].'</option>';
											}												
									echo'	</select><br>	
							
							<div id="btn">
								<input type="submit" value="Proceed" />
								<button onClick="history.go(-1);">Back</button>
							</div>
					</form>
				</div> ';
			?>	
			<div id="mask"></div>
		
				<div id="mbody">
					<div id="mc_rcv1">
						<h2> LOG PO AND RIS INFORMATION </h2>
				
					</div>
				</div>
			

		<?php
			include 'footer.php';
		?>
	</div>
<script src="angular.js"></script>									
										
</body>
</html>