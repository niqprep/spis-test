<?php 
/*********************************************** 
* Script Name : po - bidding* 
* Scripted By : Monique Prepose * 
* Email : nicprep@ymail.com *
* Details: User selects Bidding Process before he/she can select supplier(po2.php)
***********************************************/ 
session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "po";

$qrycat = "SELECT distinct(biddingdte) FROM bidding where bid_stat = '1' order by biddingdte asc ";
$resultcat = $conn->query($qrycat);
$biddte = array();

$ctrcat = 0;

if ($resultcat->num_rows > 0)
{
	while($rowcat = $resultcat->fetch_assoc())
	{
		$biddte[] = $rowcat['biddingdte'];
			
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
					$(id).css('top',  winH/2-$(id).height()/1);
					$(id).css('left', winW/2-$(id).width()/2);
				
					//transition effect
					$(id).fadeIn(1000); 	
				
			
			});

		</script>
		
		
	</head>
<body>
	<div id="wholepage">		
		<?php
			include 'header.php';
		
		
			echo '<div id="boxes">';
				echo '<div id="dialog" class="window">';
					echo '<ul>
								 	<li><a href="index.php" title="Go to Home page">Dashboard</a></li>|
								 	<li><a href="searchpo.php"  title="Manage PO">Manage PO</a></li>|
								 	<li><a href="admin.php"  title="Add bidding date">Add New Bidding</a></li>
								</ul>';	
					echo '<form name="rcv" id="rcv" method="POST" action="issuehkofc.php">	';		
						
						echo '<div >

								<table id="potbls">
									<tr>
										<td>Bidding Date</td>
										<td>Bidding Description</td>
										
									</tr>
								</table>

								<div id="leftdiv">
									<table>';
										for ($i=0; $i < $ctrcat; $i++)
										{ 
											$biddte2 = new DateTime($biddte[$i]);
											$biddte2 = $biddte2->format('F d, Y');
											echo '<tr><td><a href="bidlistframe.php?date='.$biddte[$i].'" target="newpo">'.$biddte2.'</a></td></tr>';	
										}
							echo '	</table>
								</div>
								<div id="middiv" >
									<iframe name="newpo" frameborder="0" src=""> </iframe>';
									
							echo'</div>
								
							</div>';
						
					echo '</form>';
				echo '</div> ';
				
				echo '<div id="mask"></div>';
			echo '</div>';

		echo '<div id="mbody">';
		
			echo '<div id="mc_rcv1">';
				echo '<h2>Create Purchase Order</h2>';
				
			echo '</div>';
		
		echo '</div>';
		
			include 'footer.php';
		?>
	</div>
<script src="js/angular.min.js"></script>									

</body>
</html>