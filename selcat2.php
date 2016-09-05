<?php
/*USED FOR ISSUANCE OF OTHER STOCKS*/
session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 	

include 'database/dbconnect.php';
$_SESSION['currentpage'] = "issuance";

$code = array();
$desc = array();
$ctr = 0;
$sql = "SELECT * from cat 
		where stat = 'Active' and (catcode <> 'HK') and (catcode <> 'OS')
		order by catdesc";
$result = $conn->query($sql);
if ($result -> num_rows > 0) 
{
	while($row = $result-> fetch_assoc())
	{
		$code[] = $row['catcode'];
		$desc[] = $row['catdesc']; 
		$ctr++;
	}
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
				<div id="dialog" class="window">
				
				<form name="select" id="select" method="get" action="issueoth.php">
					<ul>
					 	<li><a href="index.php" title="Go to Home page">Dashboard</a></li>|
					 	<li><a href="selcat.php"  title="Go to Add Stocks page">Add Stocks</a></li>|
					 	<li><a href="additem.php"  title="Go to Add a New Item page">Add New Item</a></li>
					</ul>	

					<h1> Issuance</h1>
					<h2>Please select a category </h2>
					
					';

				echo '	
					
						<table>
							<tr>
								<td><select name="cat" autofocus>';
								for ($x=0; $x < $ctr; $x++) 
								{ 
									echo '<option value="'.$code[$x].'"> '.$desc[$x].' </option>';
								}


							  echo '</select>
								</td>
							</tr>
						</table>';


	echo '			
					<input type="submit" value="Proceed" />					<button onClick="history.go(-1);">Back</button>
					
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

