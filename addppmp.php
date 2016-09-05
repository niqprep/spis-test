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

//QUERY FOR SECTIONS
$qrysect = "	SELECT * from section left outer join dept on section.deptid = dept.id
				where section.stat = '1'
				order by name asc, sectname asc";
$ressect = $conn->query($qrysect);
$sectid = array();
$deptid = array();
$sectname = array();
$dept = array();
$ctrsect = 0;
if($ressect->num_rows > 0)
{
	while ($rowsec = $ressect->fetch_assoc())
	{
		$sectid[] = $rowsec['sect_id'];
		$deptid[] = $rowsec['deptid'];
		$sectname[] = $rowsec['sectname'];
		$dept[] = $rowsec['name'];
		$ctrsect++;
	}
}

if (isset($_POST['submit'])) 
{
	
	$sectid2 = $_POST['section'];
	$stat = $_POST['sectstat'];
	$rem = cleanthis($_POST['rem']);
	$yrid = $_POST['yrid'];
	$yr = $_POST['yr'];
	$currdate = Date("Y-m-d H:i:s");

	$chksect = array_values(mysqli_fetch_array($conn->query("SELECT sectionid from ppmp where sectionid = '$sectid2' and ppmpyrid = '$yrid' and stat = '1'")))[0];
	if($chksect == $sectid2) //if duplicate section, abort 
	{		
		echo '<script type="text/javascript">'; 
		echo 'alert("The entered section is already existing and active.\\n Please delete/disable the existing section in this PPMP year first. Thank you.");'; 
		echo 'history.go(-2);';
		echo '</script>';
	}
	else
	{		
		$starttrans = "START TRANSACTION;";
		$sqlstart = $conn->query($starttrans);
		$sql ="INSERT INTO ppmp(sectionid, ppmpyrid, remarks, createdby, createdon, stat) 
						values('$sectid2', '$yrid', '$rem', '$uid', '$currdate', '$stat')";
		$mysql = $conn->query($sql);

		
		if (!$mysql) 
		{
			//rollback CHANGES
			$qryroll = "ROLLBACK;";
			$mysqlroll = $conn->query($qryroll);
			echo '<script type="text/javascript">'; 
			echo 'alert("Something went wrong in PPMP table. Rolling back changes..\\n Please try again. Thank you.");'; 
			echo 'window.location.href = "addppmp.php?yrid='.$yrid.'&yr='.$yr.'"';
			echo '</script>';

		}
		else
		{
			$qrycom = "COMMIT;";
			$mysqlcom= $conn->query($qrycom);
			if($mysqlcom)
			{
				echo '<script type="text/javascript">'; 
				echo 'alert("PPMP for year '.$yr.' has been added successfully.\\n Thank you.");'; 
				echo 'history.go(-2);';
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
			$year = $_GET['yr'];
			$yearid = $_GET['yrid'];

			echo '<div id="boxes">
					<div id="dialog" class="window">';

				
						echo'	<p>Add new PPMP for year<i> '.$year.' </i></p>
									
									<form name="logno" id="rcv" method="post" action="">
											<input type="hidden" name="yrid" value="'.$yearid.'" />
											<input type="hidden" name="yr" value="'.$year.'" />
											<table id="popuptbl" >
												<tr> 
													<td >Select a Section</td>

													<td>
														<select name="section" required>';
												 
															  for($x=0; $x<$ctrsect; $x++)
															  {
															  	echo "<option value='".$sectid[$x]."'>".$dept[$x]." - ".$sectname[$x]." </option>";
															  }
												
									echo'				</select>
													</td>
													
												</tr>
												
												<tr> 
													<td >Status</td>
													<td >
														<select name="sectstat" id="datetime" autofocus required>
															<option value="1" selected="selected" >Active</option>
															<option value="0" >Inactive</option>
														</select>
													</td>
												</tr>
												<tr> 
													<td >Remarks</td>
													<td >
														<textarea name="rem" id="" rows="4" cols="37" maxlength="150"></textarea>
															
														
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
						Add new PPMP <br>
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