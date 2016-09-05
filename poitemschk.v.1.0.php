<?php
/*********************************************** 
* Script Name : poitemschk * 
* Scripted By : Monique Prepose * 
* Email : nicprep@ymail.com *
* Details: System informs the user of the available qty that can be requested based from the contract from the bidding and supplier
***********************************************/ 
session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';
include 'functions.php';
$_SESSION['currentpage'] = "po";

if (!isset($_POST['bidsuppid']))
	{
	header ("location: po.php");
	}
else 
	{
		//$logno = $_POST['logno'];
		//$suppid = $_POST['suppid'];
		$bidsuppid = $_POST['bidsuppid']; //00000000000000000042
		$prno = $_POST['prno'];
		$bidid = $_POST['bidid'];
		$prid = $_POST['prid']; //0000000056
		$cat = $_POST['catid']; //category code of PR
	}
//get date and time
$currentdate = date('Y-m-d');
$currentdatetime = date('Y-m-d H:i:s');
$pono2 = date("ymd-His");


///////////////////////////////check PR items from the contract
$biddte = array_values(mysqli_fetch_array($conn->query("SELECT biddingdte from bidding 
														left outer join bidsupp on bidding.bid_id = bidsupp.bid_id 
														where bidsupp.id =$bidsuppid ")))[0];
if ($cat =='HK' or $cat == 'OS')
{
	$qryitem = "SELECT * FROM pr_items left outer join stocks on pr_items.itemid = stocks.id where pr_id = $prid ";
	
}
else
{
	$qryitem = "SELECT * FROM pr_items left outer join othstocks on pr_items.itemid = othstocks.id where pr_id = $prid ";
	
}
$introk = '';
$introx = '';
$ctri = 0;
$pritemid = array();
$pritemid1 = array();
$kpritemid = array();

$kpritemqty = array();
$pritemqty = array();

$kbiditemqty = array();
$xbiditemqty = array();
$biditemqty = array();

$availpoqty = array();
$kavailpoqty = array();

$exceedcontract = array();
$okcontract = array();
//$exceedid = array();
$nocontract = array();
$resultitem = $conn->query($qryitem);
if ($resultitem->num_rows > 0)
{
	while($rowi = $resultitem->fetch_assoc())
	{
		echo '<br>itemid:'.$pritemid1[$ctri] = $rowi['itemid'];
		echo '-ctr is '.$ctri.'--pritemqty: '.$pritemqty1[$ctri] = $rowi['pr_qty']; //PR qty

		$biditemsql = "SELECT contractqty from bidsuppitem where biddsupp_id = $bidsuppid and itemid = $pritemid1[$ctri]";
		$res = $conn->query($biditemsql);
		if ($res->num_rows > 0)
		{
			while($rowg = $res->fetch_assoc())
			{
				echo '-contract:'.$biditemqty[] = $rowg['contractqty']; //qty per contract
			}
		}
		else
		{
			echo 'nocontrac:'.$biditemqty[$ctri] = 0;
			$nocontract[$ctri] = 'No Contract';
		}
		

		$pototitemqty[$ctri] = array_values(mysqli_fetch_array($conn->query("SELECT sum(poqty) from po_poitems where poitem_id = $pritemid1[$ctri]")))[0];
		if ($pototitemqty[$ctri] == '') 
		{
			echo '--pototal:'.$pototitemqty[$ctri] = 0;
		}
		
		echo '--availqty: '.$availpoqty[$ctri] = $biditemqty[$ctri] - $pototitemqty[$ctri];
		//if exceeded sa contract ung total po at 
		if ($pritemqty1[$ctri] > $availpoqty[$ctri] ) 
		{
			$introx = "The following Item/s have already exceeded their contract:";
			$exceedcontract[] = $rowi['item_name'].' '.$rowi['desc'];
			//$exceedid[] = $rowi['itemid'];
			echo '--itemid: '.$pritemid[$ctri] = $rowi['itemid'];
			echo '--pritemqty2: '.$pritemqty[$ctri] = $rowi['pr_qty']; //PR qty
			$xbiditemqty[] = $biditemqty[$ctri]; //CONTRACT QTY
		}
		else
		{
			$introk = "The following Item/s are good to proceed with creating Purchase Order:";
			$okcontract[] = $rowi['item_name'].' '.$rowi['desc'];
			$kpritemid[] = $pritemid1[$ctri];
			$kpritemqty[] = $pritemqty1[$ctri]; //PR qty
			$kbiditemqty[] = $biditemqty[$ctri]; //CONTRACT QTY
			$kavailpoqty[] = $availpoqty[$ctri]; // available PO qty
		}


		$ctri++; //total no. of items in the PR
	}
}
$logno = $ctri;

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
					$(id).css('top',  winH/1-$(id).height(600)/1);
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
					
					<form name="logno" id="rcv" method="post" action="createpo.php">';
						
							if(count($nocontract) > 0) 
							{
								echo '	<table id="potbls2">
										<tr>
											<td colspan = "7"> '.$introx.'
											</td>
										</tr>								
									</table>					
									<div id="list100perc">
									
										<table id="potbls2" style="border: solid 1px black; border-collapse: collapse;width: 750px;" >
											<tr style="border: solid 1px black;width: 450px;">
												<td colspan = "1" ">Item Description</td>
												<td colspan = "2">PR qty</td>
												<td colspan = "2">Contract qty</td>
												<td colspan = "2">Avail qty</td>
												
											</tr>';

											for ($i=0; $i < count($exceedcontract) ; $i++) 
											{ 
												if (isset($nocontract[$i] )) 
												{
													$biditemqty[$i] = $nocontract[$i];
													$availpoqty[$i] = $nocontract[$i];
												}
												
												echo '<tr style="color:red;font-size:16px;">
														<td colspan = "1" >
															<b >'.$exceedcontract[$i].'</b>
														</td>
														<td colspan = "2">'.$pritemqty[$i].'</td>
														<td colspan = "2">'.$biditemqty[$i].'</td>
														<td colspan = "2">'.$availpoqty[$i].'</td>
													  </tr>	';
											}	
								echo'	</table>';
							}
					
				
							if(count($okcontract) > 0)
							{
								$cntitem = count($okcontract);
								echo '<input type="hidden" name="cntitem" value="'.$cntitem.'" /> ';
								echo '<input type="hidden" name="bidsuppid" value="'.$bidsuppid.'" /> ';
								echo '<input type="hidden" name="prid" value="'.$prid.'" /> ';
								echo'<br><table id="potbls2">
									<tr>
										<td> '.$introk.'
										</td>
									</tr>	

									</table>
									<table id="potbls2" style="border: solid 1px black; border-collapse: collapse;width: 750px;" >
											<tr style="border: solid 1px black;">
												<td colspan = "1">Item Description</td>
												<td colspan = "2">PR qty</td>
												<td colspan = "2">Contract qty</td>
												<td colspan = "2">Avail qty</td>
												
											</tr>';
											

												for ($i=0; $i < count($okcontract) ; $i++) 
												{ 
													echo '<input type="hidden" name="pritemqty'.$i.'" value="'.$kpritemqty[$i].'" /> ';
													echo '<input type="hidden" name="biditemqty'.$i.'" value="'.$kbiditemqty[$i].'" /> ';
													echo '<input type="hidden" name="availitemqty'.$i.'" value="'.$kavailpoqty[$i].'" /> ';
													echo '<input type="hidden" name="pritemid'.$i.'" value="'.$kpritemid[$i].'" /> ';
																							
													echo '<tr style="color:red;font-size:16px;">
															<td colspan = "1" style="width: 450px;">
																<b >'.$okcontract[$i].'</b>
															</td>
															<td colspan = "2">'.$kpritemqty[$i].'</td>
															<td colspan = "2">'.$kbiditemqty[$i].'</td>
															<td colspan = "2">'.$kavailpoqty[$i].'</td>
														  </tr>	';
												}	
							echo'	</table>';
							}
					echo'	</div>';
																  
							echo'		
							<div id="btn">';
								if (count($okcontract) > 0) 
								{
									echo '<input type="submit" value="Proceed" />';
									echo '<button onClick="history.go(-1);">Back</button>';
								}	
								else
								{
									echo '<button onClick="history.go(-1);">Back</button>';								
								}
					echo '	</div>
					</form>
					<i>Click Proceed to continue with the available item/s for P.O.</i>
				</div> ';
			?>	
			<div id="mask"></div>
		
				<div id="mbody">
					<div id="mc_rcv1">
						<h2> LOG PR INFORMATION </h2>
				
					</div>
				</div>
			

		<?php
			include 'footer.php';
		?>
	</div>
<script src="angular.js"></script>									
										
</body>
</html>