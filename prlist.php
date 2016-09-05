<?php
session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "po";

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
		<h2> Purchase Requests</h2>
			<div id="tabs-container">
 				
				<ul class="tabs-menu">
			  
					<li class="current"><a href="#tab-1">New PR</a></li>
			  
					<li><a href="#tab-2">PO'd PR</a></li>
			  
					<!-- <li><a href="#tab-3">Approved by MCC</a></li>
			  
					<li><a href="#tab-4">Forwarded to Supplier</a></li>
			 
					<li><a href="#tab-5">Cancelled</a></li> -->
			 
				</ul>
			 
				<div class="tab">
			 
					<div id="tab-1" class="tab-content">
					This tab contains all newly created and approved Purchase Requests (P.R.)  <br>
					<table class="tblframe">
						<tr>
							
							<th>PR #</th>
							<th colspan="2">1st Line Item</th>
							<th>Section</th>
							<th>Date</th>
							<th>Actions</th>

						</tr>
					</table>
					<iframe src="newpr.php" name="newpo" frameborder="0" ></iframe>
			 		</div>

			  		<div id="tab-2" class="tab-content">
			  		This tab contains all Purchase Orders (P.O.) that have been forwarded to Budget for approval of Medical Center Chief. <br>
					<table class="tblframe">
						<tr>
							
							<th>PR #</th>
							<th>1st Line Item</th>
							<th>Section</th>
							<th>Date</th>
							<th>Actions</th>

						</tr>
					</table>
					<iframe src="budgetpo.php" name="newpo" frameborder="0" ></iframe>
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