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

///////////////////////////////////////////////////////////////////////////////////////////////////////start revision 8/19/2016 by MPP
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
						//pr item variables
						$pritemid = array(); 
						$pritemqty = array();
						//bid supp variables
						$biditemqty = array(); 
						$availpoqty = array();
						//poitems variables
						$pototitemqty = array();
						//nocontract items array
						$nocontract_id = array();
						$nocontract_name = array();
						//okay to proceed items array
						$ok_id = array();
						$ok_name = array();
						$ok_prqty = array();
						$ok_conqty = array();
						$ok_availqty = array();
						//exceeded items array
						$ex_id = array();
						$ex_name = array();
						$ex_prqty = array();
						$ex_conqty = array();
						$ex_availqty = array();
						$okctr = 0;
						$exctr = 0;
						$noctr = 0;
						$ctri = 0;

						$resultitem = $conn->query($qryitem);
						if ($resultitem->num_rows > 0)
						{
							while($rowi = $resultitem->fetch_assoc())
							{
								echo '<br>itemid:'.$pritemid[$ctri] = $rowi['itemid'];
								echo '-ctr is '.$ctri.'--pritemqty: '.$pritemqty[$ctri] = $rowi['pr_qty']; //PR qty

								//get contract qty
								$biditemsql = "SELECT contractqty from bidsuppitem where biddsupp_id = $bidsuppid and itemid = $pritemid[$ctri]";
								$res = $conn->query($biditemsql);

								//with contract
								if ($res->num_rows > 0)
								{
									while($rowg = $res->fetch_assoc())
									{

										//echo '-contract:'.$biditemqty[$ctri] = $rowg['contractqty']; //qty per contract
										if ($rowg['contractqty'] == '') {
										$biditemqty[$ctri] = 0;	# code...
										}
										else
										{
											$biditemqty[$ctri] = $rowg['contractqty'];
										}
										//get PO'd qty
										$pototitemqty[$ctri] = array_values(mysqli_fetch_array($conn->query("SELECT sum(poqty) from po_poitems where poitem_id = $pritemid[$ctri]")))[0];
										if ($pototitemqty[$ctri] == '') 
										{
											echo '--pototal:'.$pototitemqty[$ctri] = 0;
										}
										$availpoqty = $biditemqty[$ctri] - $pototitemqty[$ctri];

										if($pritemqty[$ctri] <= $availpoqty)
										{
											//ok to proceed items
											$ok_id[$okctr] = $pritemid[$ctri];
											$ok_name[$okctr] = $rowi['item_name'].' '.$rowi['desc'].' '.$rowi['brand'].', '.$rowi['unit'];
											$ok_prqty[$okctr] = $pritemqty[$ctri];
											$ok_conqty[$okctr] = $biditemqty[$ctri];
											$ok_availqty[$okctr] = $availpoqty;
											$okctr++;
										}
										else
										{
											//items that has exceeded the contract
											$ex_id[$exctr] = $pritemid[$ctri];
											$ex_name[$exctr] = $rowi['item_name'].' '.$rowi['desc'].' '.$rowi['brand'].', '.$rowi['unit'];
											echo $ex_prqty[$exctr] = $pritemqty[$ctri];
											echo $ex_conqty[$exctr] = $biditemqty[$ctri];
											echo $ex_availqty[$exctr] = $availpoqty;
											$exctr++;
										}

									}
								}
								//no contract
								else 
								{
									$biditemqty[$noctr] = 0;
									$nocontract_id[$noctr] = $pritemid[$ctri]; //save the no contract items in an array
									$nocontract_name[$noctr] = $rowi['item_name'].' '.$rowi['desc'].' '.$rowi['brand'].', '.$rowi['unit'];
									$noctr++;
								}
								$ctri++; //total no. of items in the PR
							}
						}
						$logno = $ctri;
	
						//$getitemsql = "SELECT * from stocks";
					
					///////////////////////////////////////////////////////////////////////////////////////////////////////end revision 8/19/2016 by MPP				
				


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
					
					<form name="logno" id="rcv" method="post" action="createpo.php">
							<input type="hidden" name="bidsuppid" value="'.$bidsuppid.'" />
							<input type="hidden" name="prid" value="'.$prid.'" />
							';
							
							//display items that has no contract
							$mjr = 0;
							if(isset($nocontract_id[0]) )
							{
								echo '<table id="record2">
										<tr>
											<td><br><h3>Items with NO CONTRACT</h3></td>
											<td></td>
											<td></td>
										</tr>
									  </table>';

								echo '<table id="" >';
								foreach($nocontract_id as $value)
								{
								 	echo '<input type="hidden" name="nocontractid[]" value="'.cleanthis($value). '">';
								 	$no = $mjr +1;
								 	echo '	<tr>
												<td colspan="3">'.$no.'.'.$nocontract_name[$mjr].' ('.$value.')
												
												</td>												
											</tr>							
											';
									$mjr++;

								}
								echo '</table>';
							}

							//display items that exceeded contract
							$mjr = 0;
							if(isset($ex_id[0]))
							{
								echo '<table id="record2">
										<tr>
											<td colspan="2"><br><h3>Items that exceeded the contract</h3></td>											
											<td></td>
											<td></td>
										</tr>
										
									  </table>';

								echo '<table  >
										<tr>
											<td>Item Description</td>
											<td>PR Qty</td>
											<td>Cont Qty</td>
											<td> Avail Qty</td>
										</tr>';

								foreach($ex_id as $value_ex)
								{
								 	echo '<input type="hidden" name="excontractid[]" value="'.cleanthis($value_ex).'">';
								 	$no = $mjr +1;
								 	echo '	<tr>
												<td>'.$no.'. '.$ex_name[$mjr].' ('.$value_ex.')</td>
												<td>'.$ex_prqty[$mjr].'</td>
												<td>'.$ex_conqty[$mjr].'</td>
												<td>'.$ex_availqty[$mjr].'</td>

											</tr>							
											';
									$mjr++;

								}
								echo '</table>';

							}

							//display items that are okay to proceed to PO
							$mjr = 0;
							if(isset($ok_id[0]))
							{
								echo '<table id="record2">
										<tr>
											<td><br><h3>Items that are OKAY to be PO\'d</h3></td>
											<td></td>
											<td></td>
										</tr>
									  </table>';

								echo '<table id="" >
										<tr>
											<td>Item Description</td>
											<td>PR Qty</td>
											<td>Cont Qty</td>
											<td> Avail Qty</td>
										</tr>';
								foreach($ok_id as $value_ok)
								{
								 	echo '<input type="hidden" name="okcontractid[]" value="'.cleanthis($value_ok). '">';
								 	$no = $mjr +1;
								 	echo '	<tr>
												<td>'.$no.'. '.$ok_name[$mjr].' ('.$value_ok.')
												
												</td>
												<td>'.$ok_prqty[$mjr].'</td>
												<td>'.$ok_conqty[$mjr].'</td>
												<td>'.$ok_availqty[$mjr].'</td>
																								
											</tr>							
											';
									$mjr++;

								}
								echo '<input type="hidden" name="cntitem" value="'.$mjr.'" />';
								echo '</table>';
							}



					
							
																	  
							echo'		
							<div id="btn">';
								if (count($ok_id) > 0) 
								{
									echo '<input type="submit" value="Proceed" />';
									echo '<button onClick="history.go(-1);">Back</button>';
									echo '<br><i style="font-size:12px;">Click Proceed to continue with the available item/s for P.O.</i>';
									
									
								}	
								else
								{
									echo '<button onClick="history.go(-1);">Back</button>';								
									echo '<br><i style="font-size:12px;">Click Back to reselect contract / supplier</i>';
								}
					echo '	</div>
						
					</form>
					
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