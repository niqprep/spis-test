<?php
session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "admin";

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>

		
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styletab.css" rel="stylesheet" type="text/css" />	
	</head>
<body>
		
		<?php
			include 'header.php';
		?>
		<div id="mbody">
		<h2> Administrator Operations </h2>
			<div id="tabs-container">
 				
				<ul class="tabs-menu">
			  
					<li class="current"><a href="#tab-1">Bidding</a></li>
			  
					<li><a href="#tab-2">Items</a></li>
			  
					<li><a href="#tab-3">Users</a></li>
			  
					<li><a href="#tab-4">Other Providers</a></li>
			 
					<li><a href="#tab-5">My Account</a></li>
			 
				</ul>
			 
				<div class="tab">
			 
					<div id="tab-1" class="tab-content">
					
					<iframe src="bidlist.php" name="newpo" frameborder="0" ></iframe>
			 		</div>

			  		<div id="tab-2" class="tab-content">
			  		Add bidding information. <br>
					<table class="tblframe">
						<tr>
							<th>PO #</th>
							<th>Supplier</th>
							<th>1st Line Item</th>
							<th>Section</th>
							<th>Date</th>
							<th>Actions</th>

						</tr>
					</table>
					<iframe src="budgetpo.php" name="newpo" frameborder="0" ></iframe>
					</div>
					  
					<div id="tab-3" class="tab-content">
					This tab contains all Purchase Orders (P.O.) that have been approved by Medical Center Chief. <br>
					<table class="tblframe">
						<tr>
							<th>PO #</th>
							<th>Supplier</th>
							<th>1st Line Item</th>
							<th>Section</th>
							<th>Date</th>
							<th>Actions</th>

						</tr>
					</table>
					<iframe src="mccpo.php" name="searchframe" frameborder="0"  ></iframe>
			 		</div>
			  
					<div id="tab-4" class="tab-content">
					This tab contains all Purchase Orders (P.O.) that have been received by their respective suppliers and is now waiting for the delivery of items. <br>		
					<table class="tblframe">
						<tr>
							<th>PO #</th>
							<th>Supplier</th>
							<th>1st Line Item</th>
							<th>Section</th>
							<th>Date</th>
							<th>Actions</th>

						</tr>
					</table>
					<iframe src="supplierpo.php" name="searchframe" frameborder="0"  ></iframe>
					</div>

					<div id="tab-5" class="tab-content">
					This tab contains all Purchase Orders (P.O.) that have been cancelled and other details.
					<br/>	
					<table class="tblframe">
						<tr>
							<th>PO #</th>
							<th>Supplier</th>
							<th>1st Line Item</th>
							<th>Section</th>
							<th>Date</th>
							<th>Remarks</th>
							<th>Actions</th>

						</tr>
					</table>
					<iframe src="cancelledpo.php" name="searchframe" frameborder="0"  ></iframe>
					<!--<iframe src="searchpo_frame.php" name="searchframe" frameborder="0"  ></iframe>!-->
					</div>
			  
				</div>
			</div>
		</div>
		
		<?php
			include 'footer.php';
		?>

<script type="text/javascript" src="jquery-1.9.1.min.js"></script>
<script src="js/angular.min.js"></script>					
<script>
			$(document).ready(function() {
			 $(".tabs-menu a").click(function(event) {
			  event.preventDefault();
			 $(this).parent().addClass("current");
			 $(this).parent ().siblings().removeClass("current");
			 var tab = $(this).attr("href");
			  		$(".tab-content").not(tab).css("display", "none");
			 $(tab).fadeIn();
			 });
			});
</script>
</body>
</html>