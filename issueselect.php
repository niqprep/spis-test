<?php session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "issuance";

$qrycat = "SELECT * FROM itrmc_db01.cat where stat = 'Active' order by catdesc asc ";
$resultcat = $conn->query($qrycat);
$desc = array();
$ctrcat = 0;
$code = array();
if ($resultcat->num_rows > 0)
{
	while($rowcat = $resultcat->fetch_assoc())
	{
		$desc[] = $rowcat['catdesc'];
		$code[] = $rowcat['catcode'];
		$ctrcat++;
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
					$(id).css('top',  winH/2-$(id).height()/2);
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
	<div id="wholepage">		
		<?php
			include 'header.php';
		?>
		
			<div id="boxes">
				<div id="dialog" class="window">
				<p>Select a category</p>
				<form name="rcv" id="rcv" method="POST" action="issuehkofc.php">						
					<div >
						<select id="drpdwn_issue" name="cat">
						<?php
							for ($x=0; $x < $ctrcat; $x++) 
							{ 
								echo '<option value="'.$code[$x].'">'.$desc[$x].'</option>';
							}
						?>
						</select>
						
					</div>
					<div id="btn">
						<input type="submit" value="Proceed" />					
						<button onClick="history.go(-1);">Back</button>
					</div>
				</form>
				</div> 
				
				<div id="mask"></div>
			</div>

		<div id="mbody">
		
			<div id="mc_rcv1">
				<h2> Issuance > Housekeeping and other supplies</h2>
				
			</div>
		
		</div>
		
		<?php
			include 'footer.php';
		?>
	</div>
<script src="js/angular.min.js"></script>									

</body>
</html>