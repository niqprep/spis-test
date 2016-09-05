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
		<h2> PPMP </h2>
			<div id="tabs-container">
 			 
				<div class="tab">
			 
					<div id="tab-1" class="tab-content">
					
						<iframe src="ppmpyr.php" name="newpo" frameborder="0" ></iframe>
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