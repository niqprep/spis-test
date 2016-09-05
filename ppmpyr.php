<?php 
session_start();
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';
$userid = $_SESSION['userid'];
$utype = $_SESSION['u_type'];

//get ppmp details
$qryn = "SELECT  id, year, remarks, stat from ppmpyr order by year desc";
$mysqln = $conn->query($qryn);

?>

<html  style="overflow-x: hidden;">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/styletab.css" rel="stylesheet" type="text/css" />
		
	</head>
	<body>
	<h2>Select a year to view the ppmp list</h2>
	<a href="addyear.php" target="_top"> <i>Click here to add PPMP for another year </i></a> <br>
					
					<table class="tblbid">
						<tr>
							<th >PPMP Yr Id</th>
							<th >Year</th>
							<th >Remarks</th>
							<th >Status</th>
							<th>Actions</th>
							
						</tr>
						
					</table>
		<table class="tblbid">
		<?php 
			$modc =1;
			if ($mysqln->num_rows > 0)	
			{
			while($rown = $mysqln->fetch_assoc())	
				{
					
					$yrid = $rown['id'];
					$yr = $rown['year'];
							
					$remarks = $rown['remarks'];
					if ($rown['stat'] == '1') 
					{
						$yrstat = "Active";
					}
					else
					{
						$yrstat = "Inactive";
					}
					
								

					echo '
					<tr ';
					//give id to tr for the row highlight. use modulo
					if ($modc % 2 != 0) 
					{
						echo 'id=trblue';
					}
					
					echo'>
					
					<td > '.$modc.'. '.$yrid.' </td>';
					$modc++;
					
					echo '
					<td >'.$yr.' </td>
					<td >'.$remarks.' </td>
					<td> '.$yrstat.' </td>
					<td><a href="ppmpview.php?yrid='.$yrid.'&yr='.$yr.'" title="View" target="_self"> <img src="images\icons\view3.png" id="utils" ></a>
						<a href="ppmpyredit.php?yrid='.$yrid.'" title="Edit" target="_self"> <img src="images\icons\edit.png" id="utils" ></a>
						
					</td>	
					</tr>';
				}
				$modc--;
				echo "<tr>
						<td><br><br><i> ".$modc." item/s retrieved. </i>
						</td>
					 </tr>";
			}	
			
			
		?>
		</table>
	</body>
</html>