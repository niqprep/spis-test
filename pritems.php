<?php
/*********************************************** 
* Script Name : pritems * 
* Scripted By : Monique Prepose * 
* Email : nicprep@ymail.com *
* Details: User selects items that are in the PR
***********************************************/ 
session_start();

//check user
if (!isset($_SESSION['username']) || !isset($_SESSION['userid']))
{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
} 
//check bidsuppid
if (!isset($_POST['prno']))
{
	header ("location: pr.php"); 
} 
else
{
	include 'database/dbconnect.php';
	include 'functions.php';
	$_SESSION['currentpage'] = "po";
	$prno = cleanthis($_POST['prno']);

	
	$prdte = $_POST['prdte'];
	$sect = $_POST['sect'];
	list($sectid, $sectname) = explode("+", $sect);
	$reqby = $_POST['reqby'];
	$appby = $_POST['appby'];
	$appdte = $_POST['appdte'];
	$catid = $_POST['catid'];
	$logno = $_POST['noitms'];
	$ppmpyrp = $_POST['ppmpyr'];
	list($ppmpyrid, $ppmpyr) = explode("+", $ppmpyrp); 

	$purpose = cleanthis($_POST['purpose']);

	$duplpr = mysqli_fetch_array($conn->query("SELECT pr_no from pr where pr_no = $prno limit 1"));	
	if ($duplpr != '') 
	{
		echo '<script type="text/javascript">'; 
		echo 'alert("You have entered an existing PR number. \\n Please try again. Thank you.");'; 
		echo 'history.go(-1);';
		echo '</script>';
	}
	else
	{
		//check if the section has already submitted a ppmp for the selected yr
		$ppmpid = array_values(mysqli_fetch_array($conn->query("SELECT ppmpid from ppmp where sectionid= $sectid and ppmpyrid = $ppmpyrid and stat='1'")))[0];	
		if ($ppmpid == '') {
				echo '<script type="text/javascript">'; 
				echo 'alert("This section has no PPMP yet in the system. \\n Please try again. Thank you.");'; 
				echo 'window.location.href="pr.php";';
				echo '</script>';
		}
		else
		{
				if ($catid == 'HK' or $catid == 'OS') 
				{
					$qryitem = "SELECT *, ppmp_items.id as ppmpitemid from stocks left outer join ppmp_items on stocks.id = ppmp_items.itemid 
								where ppmp_items.ppmpid = $ppmpid and ppmp_items.stat = '1' and ppmp_items.cat = '$catid' ";
				}
				else
				{
					$qryitem = "SELECT *, ppmp_items.id as ppmpitemid from othstocks left outer join ppmp_items on othstocks.id = ppmp_items.itemid 
								where ppmp_items.ppmpid = $ppmpid and ppmp_items.stat = '1' and ppmp_items.cat = '$catid'  ";
				}
				$mysqlitem = $conn->query($qryitem);
				
				$ppmpitemid = array();
				$item_name = array();
				$desci = array();
				$unit = array();
				$uprice = array();
				$itemid = array();
				//$ppmpid = array();
				$ppmpqty = array();
				$totalpr = array();
				$availqty = array();

				$ctritem=0;
				
				if ($mysqlitem->num_rows > 0)	
					{
					while($rowi = $mysqlitem->fetch_assoc())	
						{
							if ($rowi['item_name'] != '')
							{
								$ppmpitemid[] = $rowi['ppmpitemid'];
								$item[] = cleanthis($rowi['item_name']);
								$desci[] = cleanthis($rowi['desc']);
								$unit[] = $rowi['unit'];
								$uprice[] = number_format($rowi['purchase_price'], 2, '.', ',');
								$itemid[] = $rowi['itemid'];
								//$ppmpid[] = $rowi['ppmpid'];
								$ppmpqty[] = $rowi['qty'];
								$totalpr[] = array_values(mysqli_fetch_array($conn->query("SELECT sum(pr_items.pr_qty)
														FROM ppmp_items left outer join pr_items on ppmp_items.itemid = pr_items.itemid
														left outer join pr on pr_items.pr_id = pr.id									
														where (year(pr.prdate) = '$ppmpyr')   and 
														ppmp_items.id = '$ppmpitemid[$ctritem]' and
														pr.status != '0'")))[0]; 
								$availqty[] = $ppmpqty[$ctritem] - $totalpr[$ctritem];
								//$brand[] = cleanthis($rowi['brand']);
								//$remarksi[] = cleanthis($rowi['bsi_rem']);
								//$cat[] = $rowi['cat']; 

								$ctritem++;
							}
						}
					}

				else
				{
					echo '<script type="text/javascript">'; 
					echo 'alert("There is no registered item for this section\'s PPMP.\\n Thank you.");'; 
					echo 'history.go(-1);';
					echo '</script>';
				}

		}
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
					$(id).css('top',  winH/1-$(id).height(winH)/1);
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
					
					<form name="logno" id="rcv" method="post" action="pritemschk.php">
						<input type="hidden" name="prno" value="'.$prno.'"/>
						<input type="hidden" name="prdte" value="'.$prdte.'"/>
						<input type="hidden" name="sectid" value="'.$sectid.'"/>
						<input type="hidden" name="reqby" value="'.$reqby.'"/>
						<input type="hidden" name="appby" value="'.$appby.'"/>
						<input type="hidden" name="appdte" value="'.$appdte.'"/>
						<input type="hidden" name="catid" value="'.$catid.'"/>
						
						<input type="hidden" name="ppmpyrid" value="'.$ppmpyrid.'"/> 
						<input type="hidden" name="purpose" value="'.$purpose.'"/>
						<input type="hidden" name="ppmpid" value="'.$ppmpid.'"/>
						<input type="hidden" name="sectname" value="'.$sectname.'"/>

						<table id="potbls2">
									<tr>
										<td>PR No.</td>
										<td style="width:220px;">'.$prno.'</td>
										<td>PR Date</td>
										<td>'.$prdte.'</td>
									</tr>
									<tr>
										<td>Section</td>
										<td>'.$sectname.'</td>
										<td>Approved on</td>
										<td>'.$appdte.'</td>
									</tr>
									<tr>
										<td>Purpose</td>
										<td colspan="3">'.$purpose.'</td>										
									</tr>									
								</table>
					
							<div id="list100perc">
							<h2>Select items/enter quantity</h2>
								<table id="potbls3">
									<tr >
										<td>Stock No.</td>
										<td>Item description</td>
										<td>PR Qty</td>
										
									</tr>';
									
									if ($logno > $ctritem)
									{
										$logno = $ctritem;
									}
									
									echo '<input type="hidden" name="logno" value="'.$logno.'"/>';
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
												
										echo'	<td><select autofocus onchange="updateText'.$ctrlog.'(this.options[this.selectedIndex].getAttribute(\'data-val\',\' price\'))" name="item'.$ctrlog.'">';
																	for ($i=0; $i < $ctritem ; $i++) 
																	{ 
																		echo ' <option data-val="You selected '.$item[$i].' '.$desci[$i].', '.$unit[$i].' - Est. Price: '.$uprice[$i].'<br> Avail PPMP qty:<b style=\'color:red\'> '.$availqty[$i].'</b>" 
																				value="'.$ppmpitemid[$i].'*'.$ppmpqty[$i].'*'.$item[$i].'*'.$desci[$i].'*'.$itemid[$i].'">'.$item[$i].', '.$desci[$i].', '.$unit[$i].'</option>';
																	}														
											echo'	</select>
												</td>
												<td>
													<input id="" type="number"  name="qty'.$ctrlog.'" min="1" step="any"  required/>
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