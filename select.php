<?php

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 	


if(!isset($_GET['std']))
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Oops! I think you are missing something.\\n Please try again.");'; 
	echo 'history.go(-1);';
	echo '</script>';
}
else
{
	$std = $_GET['std'];

}

if(isset($_GET['it']))
{
	$page = $_GET['it'];
}
else
{
	$page = 0;
}

?>
<!DOCTYPE html>
<html>
				<head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
					<title>ITRMC - Supply & Property System</title>
					<link href='css/style.css' rel='stylesheet' type='text/css' />
					<link href='css/styleselect.css' rel='stylesheet' type='text/css' />
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
						
						
					});

				</script>
				</head>

		<body >
					<div id='wholepage'>
				<?php
				include 'header.php';
				$currdate = Date("Y-m-d");
			
			
			
	echo '	<div id="mbody" >
				<div id="boxes">
				<div id="dialog" class="window">';
				if ($page == '1') {
					echo '<form name="select" id="select" method="post" action="stockcard_view.php">';
				}
				else
				{
					echo '<form name="select" id="select" method="post" action="bincard_view.php">';
				}
				echo '					
					<input type="hidden" name="std" value="'.$std.'" />
					
					<h2>Select a date: </h2>
					
					';

				echo '	
					
						<table>
							<tr>
								<td>From <input type="date" name="from" value="'.$currdate.'" autofocus/> </td>
								<td>To	<input type="date" name="to" value="'.$currdate.'" />  </td>
								</td>
							</tr>
						</table>';

if ($page == '1')
{
	echo '<input type="submit" value="View Stock Card" />';
}
else
{
	echo '<input type="submit" value="View Bincard" />';
}
	echo '			
					<button onClick="history.go(-1);">Back</button>
				</form>
				</div> 
				
				<div id="mask"></div>
			</div>
		';
									
						
						?>
						
					</form>
					
				</div>
			
			</div>
			
	</div>
	<script src="js/angular.min.js"></script>									

</body>
</html>

