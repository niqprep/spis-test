<?php 
session_start();
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';
include 'functions.php';
if (!isset($_GET['yrid']))
{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: admin.php");
} 
else
{
	$yrid = $_GET['yrid'];

}

$userid = $_SESSION['userid'];
$utype = $_SESSION['u_type'];


//get ppmp details
$qryn = "SELECT ppmp.ppmpid, ppmp.remarks, section.sectname, year, ppmp.stat from ppmp left outer join section on ppmp.sectionid = section.sect_id 
							left outer join ppmpyr on ppmp.ppmpyrid = ppmpyr.id 
		where ppmpyrid = '$yrid' and ppmp.stat = '1' 
		order by sectname ";
$section = array();
$remarks = array();
$stat = array();
$ctr=0;
$mysqln = $conn->query($qryn);
if ($mysqln->num_rows > 0)	
	{
	while($rown = $mysqln->fetch_assoc())	
		{
			$section[] = $rown['sectname'];
			$ppmpid[] = $rown['ppmpid'];
			$remarks[] = $rown['remarks'];
			$year = $rown['year'];
			if ($rown['stat'] == '1') 
			{
				$stat[] = 'Active';
			}
			else
			{
				$stat[] = 'Inactive';
			}
			
			$ctr++;
		}
	}

?>

<html  style="overflow-x: hidden;">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/styletab.css" rel="stylesheet" type="text/css" />
		<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php
			echo '<div id="backlnk">';
				echo '<h2><a href="" onClick="history.go(-1);">Back to list</a> > Sections with PPMP for the FY '.$year.' </h2>';
				echo '<br><a href="addppmp.php?yrid='.$yrid.'&yr='.cleanthis($year).'" target="_top"> Click here to add other section\'s PPMP for FY '.$year.' <a/>';
				//echo '<a id="title" href="#" target="_top">Upload supplier\'s list for this bid </a>';
				echo '<table class="tblbid">
						<tr>
							<th >PPMP ID</th>
							<th >Section</th>
							
							<th >Remarks</th>
							<th >Status</th>
							<th>Actions</th>
						</tr>	';	
				echo '</table>';
				echo '<table class="tblbid">';
						for ($i=0; $i < $ctr; $i++)
						{ 
							echo '<tr ';
							if ($i % 2 != 0) 
							{
								echo 'id=trblue';
							}
							echo '>
									<td >'.$ppmpid[$i].'</td>
									<td >'.$section[$i].'</td>
									<td>'.$section[$i].'</td>
									<td>'.$stat[$i].'</td>
									<td><a href="ppmpitemvw.php?ppmpid='.$ppmpid[$i].'&nme='.cleanthis($section[$i]).'&yr='.cleanthis($year).'" title="View" target="_self"> <img src="images\icons\view3.png" id="utils" ></a>
										<a href="ppmpitemedit.php?ppmpid='.$ppmpid[$i].'" title="Edit" target="_self"> <img src="images\icons\edit.png" id="utils" ></a>
									</td>
							</tr>';
						}
						
				echo '</table>';
			echo '</div>';
		?>
	</body>
</html>