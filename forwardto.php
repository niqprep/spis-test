<?php
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

if (!isset($_GET['djm']) or !isset($_GET['mpp']) or !isset($_GET['<3']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: searchpo.php");
	} 
$poid = $_GET['djm'];
$pono = $_GET['mpp'];
$proc = $_GET['<3'];

$qrypoamt = "SELECT poamount FROM purchase_order where po_number = '$pono'";
$mysqlpoamt = $conn->query($qrypoamt);
if($mysqlpoamt->num_rows > 0)
{
	while($rowamt = $mysqlpoamt->fetch_assoc())
	{
		$poamt = $rowamt['poamount'];
	}
}

$suppctr = 0;
$lname = array();
$fname = array();
$mname = array();
//inner join po, supplier, agentprof, profile tables
$qry06 = "SELECT * FROM purchase_order
			left outer join supplier on purchase_order.supplierid = supplier.id
			left outer join agentprof on supplier.id = agentprof.companyid
			left outer join profile on  agentprof.profileid = profile.id 
		where purchase_order.id = $poid";
$mysql06 = $conn->query($qry06);
if ($mysql06->num_rows > 0)
{
	while($row06 = $mysql06->fetch_assoc())
	{
		$fname[] = ucfirst_sentence($row06['fname']);
		$lname[] = ucfirst_sentence($row06['lname']);		
		$mname[] = ucfirst_sentence($row06['mname']);
		$agentprofid[] = $row06['agentprof_id'];
		$suppctr++;
	}     
}
			
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>

		
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styletab.css" rel="stylesheet" type="text/css" />	
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
					///$(id).css('top',  winH/2-$(id).height()/1);
					$(id).css('top',  winH/5-$(id).height(470)/2);
					$(id).css('left', winW/2-$(id).width()/2);
				
					//transition effect
					$(id).fadeIn(1000); 	
				
				//if close button is clicked
				//$('.window .close').click(function (e) {
				//	//Cancel the link behavior
				//	e.preventDefault();
				//	
				//	$('#mask').hide();
				//	$('.window').hide();
				//});		
				
				//if mask is clicked
				//$('#mask').click(function () {
				//	$(this).hide();
				//	$('.window').hide();
				//});
			});
			
		</script>
	</head>
<body>
		
		<?php
			include 'header.php';
			$currdate = Date("Y-m-d H:i:s");
			$currdate2 = Date("Y-m-d");

			echo '<div id="boxes">
					<div id="dialog" class="window">';

					if ($proc == 'tobudget')
					{
							echo'	<p>Forward PO#<i>'.$pono.' </i>to Budget Section for signature</p>
									<p> By clicking Proceed button, I confirm that the date below is correct</p>
									<form name="logno" id="rcv" method="post" action="process_forwardto.php">
											<input type="hidden" name="poid" value="'.$poid.'" />
											<input type="hidden" name="pono" value="'.$pono.'" />
											<input type="hidden" name="proc" value="'.$proc.'" />
											

											<input type="datetime" name="datetimepo" id="datetime" value="'.$currdate.'"  max="'.$currdate.'" placeholder="Date when the PO was/is forwarded to Budget Section" autofocus required />
											<br><i style="font-size: 9px;"> 24 HR Format (YYYY-MM-DD HH:MM:SS) </i>
											
											<div id="btn">
												<input type="submit" value="Proceed" />
												<button onClick="history.go(-1);">Back</button>
											</div>
									</form>';
					}
					elseif ($proc == 'new')
					{
							echo'	<p>Revert PO#<i>'.$pono.' </i>to NEW Purchase Order</p>
									<p> By clicking Proceed button, I confirm that the date below is correct</p>
									<form name="logno" id="rcv" method="post" action="process_forwardto.php">
											<input type="hidden" name="poid" value="'.$poid.'" />
											<input type="hidden" name="pono" value="'.$pono.'" />
											<input type="hidden" name="proc" value="'.$proc.'" />
											

											<input type="datetime" name="datetimepo" id="datetime" value="'.$currdate.'"  max="'.$currdate.'" placeholder="Date when the PO was/is pulled out from Budget Section" autofocus required />
											<br><i style="font-size: 9px;"> 24 HR Format (YYYY-MM-DD HH:MM:SS) </i>
											
											<div id="btn">
												<input type="submit" value="Proceed" />
												<button onClick="history.go(-1);">Back</button>
											</div>
									</form>';
					}
					elseif ($proc == 'fromMCC')
					{
							echo'	<p>PO#<i>'.$pono.' </i>is now approved and received from MCC</p>
									
									<form name="logno" id="rcv" method="post" action="process_forwardto.php">
											<input type="hidden" name="poid" value="'.$poid.'" />
											<input type="hidden" name="pono" value="'.$pono.'" />
											<input type="hidden" name="proc" value="'.$proc.'" />
											<table id="popuptbl" >
												<tr> 
													<td >ALOBS No.</td>
													<td ><input type="number" name="alobsno" id="datetime" min="0" placeholder="ALOBS no."  autofocus required /></td>
												</tr>
												<tr> 
													<td >ALOBS amount </td>
													<td ><input type="number" name="alobsamt" id="datetime"  value="'.$poamt.'"  step="any" min="0" placeholder="ALOBS amount"  required /></td>
												</tr>
												<tr>
													<td >ALOBS type </td>
													<td ><input type="text" name="alobstyp" id="datetime" min="0" placeholder="ALOBS type"  required /></td>
												</tr>
												<tr>
													<td >ALOBS date </td>
													<td ><input type="date" name="alobsdte" id="datetime" min="0" placeholder="ALOBS type"  required /></td>
												</tr>
												<tr>
													<td colspan="2"><br /></td>
												</tr>
												<tr>
													<td colspan="2">By clicking Proceed button, I confirm that the dates below are correct
														<br><i style="font-size: 9px;">NOTE: All date/time are in 24 HR Format (YYYY-MM-DD HH:MM:SS) </i></td>
												</tr>
												<tr> 
													<td ><input type="date" name="datetimepo" id="popupdate"   max="'.$currdate2.'" placeholder="Date approved by MCC"  required /> </td>
													<td ><input type="datetime" name="datetimercvd" id="datetime" value="'.$currdate.'"  max="'.$currdate.'" placeholder="ALOBS date"  required /></td>
												</tr>

												<tr> 
													<td ><i> Date Approved </i></td>
													<td ><i> Date Received </i></td>
												</tr>
												
											</table>
											
											<div id="btn">
												<input type="submit" value="Proceed" />
												<button onClick="history.go(-1);">Back</button>
											</div>
									</form>';
					}
					elseif ($proc == 'toSupplier')
					{
							echo'	<p>Supplier has successfully received PO#<i>'.$pono.' </i></p>
									
									<form name="logno" id="rcv" method="post" action="process_forwardto.php">
											<input type="hidden" name="poid" value="'.$poid.'" />
											<input type="hidden" name="pono" value="'.$pono.'" />
											<input type="hidden" name="proc" value="'.$proc.'" />
											<table id="popuptbl" >
												<tr> 
													<td >Conforme by</td>

													<td><select name="confby" id="datetime" autofocus required> ';
													
													for ($i=0; $i < $suppctr ; $i++) { 
																												
														echo '
																<option value="'.$agentprofid[$i].'"> '.$lname[$i].', '.$fname[$i].' '.$mname[$i].'</option>


															  ';
													}
														
													
													
													echo '

													</select></td>
													
												</tr>
												<tr> 
													<td >Conforme date </td>
													<td ><input type="date" name="datetimepo" id="datetime" min="0" placeholder="Conforme date"  required /></td>
												</tr>
												
												<tr>
													<td colspan="2"><br /></td>
												</tr>
												<tr>
													<td colspan="2">By clicking Proceed button, I confirm that the dates below are correct
														<br><i style="font-size: 9px;">NOTE: All date/time are in 24 HR Format (YYYY-MM-DD HH:MM:SS) </i></td>
												</tr>
												<tr>
													<td colspan="2"><br /></td>
												</tr>
												<tr> 
													<td > Date Received </td>
													<td ><input type="datetime" name="frsuppdte" id="datetime" value="'.$currdate.'"  max="'.$currdate.'" placeholder="Date Received"  required /></td>
												</tr>

												<tr>
													<td colspan="2"><br /></td>
												</tr>
												
											</table>
											
											<div id="btn">
												<input type="submit" value="Proceed" />
												<button onClick="history.go(-1);">Back</button>
											</div>
									</form>';
					}

					elseif ($proc == 'restore')
					{
							$prevstat = array_values(mysqli_fetch_array($conn->query("SELECT prev_stat from cancelledpo where po_id = '$poid'")))[0];

							echo $proc;
							echo'	<p>Restore PO# <i>'.$pono.' </i></p>
									
									<form name="logno" id="rcv" method="post" action="process_forwardto.php">
											<input type="hidden" name="poid" value="'.$poid.'" />
											<input type="hidden" name="pono" value="'.$pono.'" />
											<input type="hidden" name="proc" value="'.$proc.'" />
											<input type="hidden" name="prevstat" value="'.$prevstat.'" />
											<table id="popuptbl" >
												
												<tr>
													<td >Remarks</td>
													<td ><textarea rows="2" cols="58" name="reason" placeholder="Reason in restoring PO# '.$pono.'"  autofocus required></textarea></td>
												</tr>
												
												<tr>
													<td colspan="2"><br /></td>
												</tr>
												<tr>
													<td colspan="2">By clicking Proceed button, I confirm that the dates below are correct
														<br><i style="font-size: 9px;">NOTE: All date/time are in 24 HR Format (YYYY-MM-DD HH:MM:SS) </i></td>
												</tr>
												<tr>
													<td colspan="2"><br /></td>
												</tr>
												<tr> 
													<td > Date Restored </td>
													<td ><input type="datetime" name="datetimepo" id="datetime" value="'.$currdate.'"  max="'.$currdate.'" placeholder="Date Received" readonly  required /></td>
												</tr>

												<tr>
													<td colspan="2"><br /></td>
												</tr>
												
											</table>
											
											<div id="btn">
												<input type="submit" value="Proceed" />
												<button onClick="history.go(-1);">Back</button>
											</div>
									</form>';
					}
					

					echo '</div> 
					
				<div id="mask"></div>';
		?>

		<div id="mbody">
		<h2> Search PO </h2>
			<div id="tabs-container">
 				
				<ul class="tabs-menu">
			  
					<li class="current"><a href="#tab-1">New Purchase Orders</a></li>
			  
					<li><a href="#tab-2">Forwarded to Budget</a></li>
			  
					<li><a href="#tab-3">Approved by MCC</a></li>
			  
					<li><a href="#tab-4">Forwarded to Supplier</a></li>
			 
					<li><a href="#tab-5">Cancelled</a></li>
			 
				</ul>
			 
				<div class="tab">
			 
					<div id="tab-1" class="tab-content">
					This tab contains all newly created Purchase Orders (P.O.) that are to be forwarded to Budget and other offices for approval of the Medical Center Chief. <br>
					<table class="tblframe">
						<tr>
							<!-- <td>PO #</td>
							<td>Supplier</td>
							<td>1st Line Item</td>
							<td>Section</td>
							<td>Date</td>
							<td>Action</td> -->
							<th>PO #</th>
							<th>Supplier</th>
							<th>1st Line Item</th>
							<th>Section</th>
							<th>Date</th>
							<th>Actions</th>

						</tr>
					</table>
					<iframe src="newpo.php" name="newpo" frameborder="0" ></iframe>
			 		</div>

			  		<div id="tab-2" class="tab-content">
			  		
					</div>
					  
					<div id="tab-3" class="tab-content">
					
			 		</div>
			  
					<div id="tab-4" class="tab-content">
					This tab contains all Purchase Orders (P.O.) that have been received by their respective suppliers and is now waiting for the delivery of items. <br>		
					</div>

					<div id="tab-5" class="tab-content">
					This tab contains all Purchase Orders (P.O.) that have been cancelled and other details.
					</div>
			  
				</div>
			</div>
		</div>
		
		<?php
			include 'footer.php';
		?>


</body>
</html>