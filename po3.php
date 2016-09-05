<?php
/*********************************************** 
* Script Name : po - items * 
* Scripted By : Monique Prepose * 
* Email : nicprep@ymail.com *
* Details: User selects items based from the selected bidder(po2.php) before he/she can create po(pomain2.php)
***********************************************/ 
session_start();

//check user
if (!isset($_SESSION['username']))
{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
} 
//check bidsuppid
if (!isset($_POST['bidsuppid']))
{
	
	header ("location: po.php");
} 
else
{
	$bidsuppid = $_POST['bidsuppid'];
	$catid = $_POST['catid'];
	$logno = $_POST['logno'];
}

include 'database/dbconnect.php';
include 'functions.php';
$_SESSION['currentpage'] = "po";


///////////////////////////////get bid details
$qrybid = "SELECT bidding.biddingdte, bidding.description, bidsupp.remarks, supplier.name, bidsupp.supp_id
				FROM bidding left outer join bidsupp on bidding.bid_id = bidsupp.bid_id
							 left outer join supplier on bidsupp.supp_id = supplier.id							 
				where bidsupp.id = '$bidsuppid' ";
$resultbid = $conn->query($qrybid);
if ($resultbid->num_rows > 0)
{
	while ($rowb = $resultbid->fetch_assoc())
	{
		$biddte2 = new DateTime( $rowb["biddingdte"]);
		$biddte2 = $biddte2->format('F d, Y');
		$descript = $rowb["description"];
		if ($rowb['remarks'] == '') 
		{
			$rem = '--';
		}
		else
		{
			$rem = $rowb['remarks'];
		}
		$supplier = $rowb['name'];
		$suppid = $rowb['supp_id'];

	}
}


///////////////////////////////get bidding items details
if ($catid == 'HK' or $catid == 'OS') 
{
	$qrybid = "SELECT stocks.`desc` as descrip, bsi_id, uprice, cat, item_name, brand, unit, bsi_rem from bidsuppitem left outer join stocks on itemid = stocks.id
			where bidsuppitem.biddsupp_id = $bidsuppid and cat = '$catid' and istatus = '1' ";
}
else
{
	$qrybid = "SELECT othstocks.`desc` as descrip, bsi_id, uprice, cat, item_name, brand, unit, bsi_rem from bidsuppitem left outer join othstocks on itemid = othstocks.id
			where bidsuppitem.biddsupp_id = $bidsuppid and cat = '$catid' and istatus = '1'";
}
$mysqlitem = $conn->query($qrybid);
$ctr=0;
if ($mysqlitem->num_rows > 0)	
	{
	while($rowi = $mysqlitem->fetch_assoc())	
		{
			if ($rowi['item_name'] != '')
			{
				$bsiid[] = $rowi['bsi_id'];
				$item[] = cleanthis($rowi['item_name']);
				$descrip[] = cleanthis($rowi['descrip']);
				$brand[] = cleanthis($rowi['brand']);
				$unit[] = $rowi['unit'];

				$uprice[] = number_format($rowi['uprice'], 2, '.', ',');
				$remarksi[] = cleanthis($rowi['bsi_rem']);
				$cat[] = $rowi['cat'];
				$ctr++;
			}
		}
	}

else
{
	echo '<script type="text/javascript">'; 
	echo 'alert("There is no registered item for this supplier/bid.\\n Thank you.");'; 
	echo 'history.go(-1);';
	echo '</script>';
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
					$(id).css('top',  winH/1-$(id).height(700)/1);
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
					
					<form name="logno" id="rcv" method="post" action="poadd.php">
						<input type="hidden" name="logno" value="'.$logno.'"/>
						<input type="hidden" name="catid" value="'.$catid.'"/>
						<input type="hidden" name="suppid" value="'.$suppid.'"/>
						<input type="hidden" name="bidsuppid" value="'.$bidsuppid.'"/>
						<table id="potbls2">
									<tr>
										<td>Bidding Date</td>
										<td>'.$biddte2.'</td>
										
									</tr>
									<tr>
										<td>Bidding Description</td>
										<td>'.$descript.'</td>
										
									</tr>
									<tr>
										<td>Select Supplier</td>
										<td>'.$supplier.'</td>
										
									</tr>
									<tr>
										<td>Supplier/Bidding Remarks</td>
										<td>'.$rem.'</td>
										
									</tr>
									<tr>
										<td><i>Select items/enter quantity</i></td>
										<td></td>
										
									</tr>
								</table>
					
							<div id="list">
								<table id="potbls3">';
									

									$ctrlog =0;
									$numbering = 1;
									while ($ctrlog < $logno) 
									{
										echo '<script type="text/javascript">'; 
										echo 'function  updateText'.$ctrlog.'(nttest)';
										echo '{';
										echo 'document.getElementById("adv'.$ctrlog.'").innerHTML=nttest;';
										echo '}';
										echo '</script>';

										echo '<tr>
												<td>'.$numbering.'. </td>';
												
										echo'		<td><select autofocus onchange="updateText'.$ctrlog.'(this.options[this.selectedIndex].getAttribute(\'data-val\',\' price\'))" name="item'.$ctrlog.'">';
																	for ($i=0; $i < $ctr ; $i++) 
																	{ 
																		echo ' <option data-val="You selected '.$item[$i].' '.$descrip[$i].' '.$brand[$i].' - '.$uprice[$i].'" 
																				value="'.$bsiid[$i].'">'.$item[$i].', '.$descrip[$i].', '.$brand[$i].', '.$unit[$i].'</option>';
																	}

														
											echo'				</select>
												</td>
												<td>
													<input id="" type="number" name="qty'.$ctrlog.'" min="1" required/>
												</td>

											</tr>
											<tr>
												<td></td>
												<td colspan="2" style="font-size:13px;color: #768088;" id="adv'.$ctrlog.'">
													
													</td>
											</tr>';

										$ctrlog++;
										$numbering++;
									}


						echo '	</table>
							</div>';
										
										
										
									

									  
							echo'		
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