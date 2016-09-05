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
$_SESSION['currentpage'] = "admin";
$utype = $_SESSION['u_type'];
$uid = $_SESSION['userid'];

if (isset($_POST['submit'])) 
{
	$yr = $_POST['yr'];
	$stat = $_POST['stat'];
	$rem = cleanthis($_POST['bidrem']);
	$currdate = Date("Y-m-d H:i:s");

	echo $chkyr = array_values(mysqli_fetch_array($conn->query("SELECT year from ppmpyr where year = '$yr' and stat = '1'")))[0];
	if($chkyr == $yr) //if duplicate year, abort 
	{
		echo '<script type="text/javascript">'; 
		echo 'alert("The entered year is already existing and active.\\n Please delete/disable the existing year first. Thank you.");'; 
		echo 'window.location.href = "ppmp.php"';
		echo '</script>';
	}
	else
	{
		$starttrans = "START TRANSACTION;";
		$sqlstart = $conn->query($starttrans);
		$sql ="INSERT INTO ppmpyr(year, remarks, createdby, createdon, stat) 
						values('$yr', '$rem', '$uid', '$currdate', '1')";
		$mysql = $conn->query($sql);

		
		if (!$mysql) 
		{
			//rollback CHANGES
			$qryroll = "ROLLBACK;";
			$mysqlroll = $conn->query($qryroll);
			echo '<script type="text/javascript">'; 
			echo 'alert("Something went wrong in PPMP year table. Rolling back changes..\\n Please try again. Thank you.");'; 
			echo 'window.location.href = "ppmp.php"';
			echo '</script>';

		}
		else
		{
			$qrycom = "COMMIT;";
			$mysqlcom= $conn->query($qrycom);
			if($mysqlcom)
			{
				echo '<script type="text/javascript">'; 
				echo 'alert("'.$yr.' is added successfully.\\n Thank you.");'; 
				echo 'window.location.href = "ppmp.php"';
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
					$(id).css('top',  winH/5-$(id).height(330)/2);
					$(id).css('left', winW/2-$(id).width()/2);
				
					//transition effect
					$(id).fadeIn(1000); 	
			});
			
		</script>
	</head>
<body>
		
		<?php
			include 'header.php';
			$currdate = Date("Y-m-d H:i:s");
			$curryr = Date("Y");

			echo '<div id="boxes">
					<div id="dialog" class="window">';

				
						echo'	<p>Add new Fiscal Year<i> </i></p>
									
									<form name="logno" id="rcv" method="post" action="">
											
											<table id="popuptbl" >
												<tr> 
													<td >PPMP Year</td>

													<td><input type="number" min="2016" max="2088" name="yr" id="datetime" placeholder="Enter Fiscal Year" value="'.$curryr.'" autofocus required></td>
													
												</tr>
												
												<tr> 
													<td >Status</td>
													<td >
														<select name="stat" id="datetime" autofocus required>
															<option value="1" selected="selected" >Active</option>
															<option value="0" >Inactive</option>
														</select>
													</td>
												</tr>
												<tr> 
													<td >Remarks</td>
													<td >
														<textarea name="bidrem" id="" rows="4" cols="37" maxlength="150"></textarea>
															
														
													</td>
												</tr>
												
												
											</table>
											
											<div id="btn">
												<input type="submit" value="Proceed" name="submit" />
												<button onClick="history.go(-1);">Back</button>
											</div>
									</form>';

					echo '</div> 
					
				<div id="mask"></div>';
		?>

		<div id="mbody">
		<h2> Administrator Operations</h2>
			<div id="tabs-container">
 				
				
				<div class="tab">
			 
					<div id="tab-1" class="tab-content">
						Add new Fiscal Year<br>
						<table class="tblframe">
							
						</table>
						<iframe src="" name="newpo" frameborder="0" ></iframe>
			 		</div>

			  	
			  
				</div>
			</div>
		</div>
		
		<?php
			include 'footer.php';
		?>


</body>
</html>