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

if (!isset($_GET['djm']) or !isset($_GET['mpp']) )
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: searchpo.php");
	} 
$poid = $_GET['djm'];
$pono = $_GET['mpp'];


$qrypoamt = "SELECT * FROM purchase_order where po_number = '$pono'";
$mysqlpoamt = $conn->query($qrypoamt);
if($mysqlpoamt->num_rows > 0)
{
	while($rowamt = $mysqlpoamt->fetch_assoc())
	{
		$poamt = $rowamt['poamount'];
		$podate = $rowamt['podate'];
		$statold = $rowamt['status'];
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
			$podate = new DateTime($podate);
			$podate = $podate->format('Y-m-d');


			echo '<div id="boxes">
					<div id="dialog" class="window">';

					
							echo'	<p>Are you sure you want to cancel PO#<i>'.$pono.' </i> with the following details:</p>
									
									<form name="logno" id="rcv" method="post" action="#">
											<input type="hidden" name="poid" value="'.$poid.'" />
											<input type="hidden" name="pono" value="'.$pono.'" />
											<input type="hidden" name="statold" value="'.$statold.'" />

											<table id="popuptbl" >
												<tr> 
													<td >Date</td>

													<td>'.$podate.'</td>
													
												</tr>
												<tr> 
													<td >Total Amount</td>
													<td >Php '.$poamt.'</td>
												</tr>
												
												<tr>
													<td >Reason</td>
													<td ><textarea rows="2" cols="58" name="reason" placeholder="Reason for cancellation"  autofocus required></textarea></td>
												</tr>
												<tr>
													<td colspan="2">By clicking Proceed button, I confirm that the date below is correct
														<br><i style="font-size: 9px;">NOTE: All date/time are in 24 HR Format (YYYY-MM-DD HH:MM:SS) </i></td>
												</tr>
												<tr>
													<td colspan="2"><br /></td>
												</tr>
												<tr> 
													<td > Date cancelled </td>
													<td ><input type="datetime" name="candte" id="datetime" value="'.$currdate.'"  max="'.$currdate.'" placeholder="Date Received"  required readonly /></td>
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