<?php
/*********************************************** 
* Script Name : pr* 
* Scripted By : Monique Prepose * 
* Email : nicprep@ymail.com *
* Details: User enters Purchase Request information before checking the availability of the items that are to be PO'd 
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
$currentdate = date('Y-m-d');

//QUERY FOR SECTIONS
$qrysect = "	SELECT * from section left outer join dept on section.deptid = dept.id
				where section.stat = '1'
				order by sectname asc";
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

//get all employee's list
$qryemp = "SELECT * FROM profile WHERE status = '1' order by lname, fname, mname";
$resultemp = $conn->query($qryemp);

$empid = array();
$empfname = array();
$emplname = array();
$empctr=0;
if ($resultemp->num_rows > 0)
{
	while($rowe = $resultemp->fetch_assoc())
	{
		$emplist[]= $rowe['lname'].", ".$rowe['fname']." ".$rowe['mname'];
		$empid[]= $rowe['id'];
		$empctr++;
	}
}
/////////////////////////////get mcc's name
$mcc = array_values(mysqli_fetch_array($conn->query("SELECT CONCAT (profile.fname,' ',profile.mname, ' ',profile.lname) from specialemp
LEFT OUTER JOIN  `profile` on  specialemp.profid = `profile`.id")))[0];
$mccid = array_values(mysqli_fetch_array($conn->query("SELECT id from specialemp
LEFT OUTER JOIN  `profile` on  specialemp.profid = `profile`.id")))[0];

/////////////////////////////QUERY DB FOR CATEGORIES
$qrycat = "SELECT * from cat
			where stat = '1'";
$resultcat = $conn->query($qrycat);
$catid = array();
$catcode = array();
$catdesc = array();
$ctrcat = 0;
if ($resultcat->num_rows > 0)
{
	while ($rowcat = $resultcat->fetch_assoc())
	{
		$catid[] = $rowcat['catid'];
		$catcode[] = $rowcat["catcode"];
		$catdesc[] = $rowcat["catdesc"];
		$ctrcat++;
	}
}

//get ppmp yr details
$qryn = "SELECT  id, year from ppmpyr where stat ='1' order by year desc";
$mysqln = $conn->query($qryn);
$ppmpid = array();
$ppmpyr = array();
$ctryr = 0;
if ($mysqln->num_rows > 0) {
	while ($row = $mysqln->fetch_assoc()) {
		$ppmpid[] = $row['id'];
		$ppmpyr[] = $row['year'];
		$ctryr++;
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
	<div id="wholepage"">		
		<?php
			include 'header.php';
		
		
			echo '<div id="boxes">
				<div id="dialog" class="window">
				<ul>
				 	<li><a href="index.php" title="Go to Home page">Dashboard</a></li>|
				 	<li><a href="searchpo.php"  title="Manage PO">Manage PO</a></li>|
				 	<li><a href="ppmp.php"  title="Add PPMP">Add New PPMP</a></li>
				</ul>					
					<form name="logno"  method="post" action="pritems.php">
						<table id="potbls2">
									<tr>
										<td>PR No./Date</td>
										<td><input type="number" min="0" name="prno" placeholder="Purchase Request #" autofocus required /></td>
										
										<td><input type="date" name="prdte" placeholder="Purchase Request Date" max="'.$currentdate.'" value="'.$currentdate.'"required /></td>
									</tr>
									
									<tr>
										<td>Department</td>
										<td>
											<select name="sect"  >';
											for ($i=0; $i < $ctrsect; $i++) 
												{ 
													echo '<option value="'.$sectid[$i].'+'.$sectname[$i].'"> '.$sectname[$i].'</option>';
												}		
							echo'			</select>
											
										</td>	
										<td>
											<select name="reqby"  >';
											for($x=0; $x<$empctr; $x++)
												  {
												  	echo "<option value='".$empid[$x]."'>".$emplist[$x]." </option>";
												  }		
							echo'			</select>
										</td>									
									</tr>
									
									<tr>
										<td>Approved by</td>
										<td><input type="text"  name="appy" value="'.$mcc.'" readonly/><input type="hidden" name="appby" value="'.$mccid.'" /></td>										
										<td><input type="date" name="appdte" max="'.$currentdate.'" value="'.$currentdate.'" placeholder="Purchase Request #" required /></td>										
									</tr>
									
									<tr>
										<td>PR item\'s Category</td>
										<td>
											<select  name="catid"  required >';
												for($x=0; $x < $ctrcat; $x++ )
												{
													echo "<option value=".$catcode[$x].">".$catdesc[$x]."</option>"; 											
												}
												
								echo'		</select>
										</td>
									</tr>
									<tr>
										<td>Items in the PR?</td>
										<td><input type="number"  name="noitms" value="1" /></td>																
									</tr>
									<tr>
										<td>PPMP year</td>
										<td>
											<select  name="ppmpyr"  required >';
												for($x=0; $x < $ctryr; $x++ )
												{
													echo "<option value='".$ppmpid[$x]."+".$ppmpyr[$x]."'>".$ppmpyr[$x]."</option>"; 											
												}
												
								echo'		</select>
										</td>
									</tr>
									<tr>
										<td>Purpose</td>
										<td colspan="2">
											<textarea rows="3" cols="63" name="purpose" required></textarea>
										</td>										
									</tr>
								</table>
							<div id="btn">
								<input type="submit" value="Proceed" />
								<button onClick="history.go(-1);">Back</button>
							</div>
					</form>
				</div> ';
			?>	
			<div id="mask"></div>
		
				<div id="mbody">
					<div id="mc_rcv1">
						<h2> LOG PO AND RIS INFORMATION </h2>
				
					</div>
				</div>
			

		<?php
			include 'footer.php';
		?>
	</div>
<script src="angular.js"></script>									
										
</body>
</html>