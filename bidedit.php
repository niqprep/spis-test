<?php 
session_start();
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';
if (!isset($_GET['bidid']))
{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: admin.php");
} 
else
{
	$bidid = $_GET['bidid'];
}

$userid = $_SESSION['userid'];
$utype = $_SESSION['u_type'];


//get bid details
$qryn = "SELECT  * from bidding where bid_id = '$bidid'";
$mysqln = $conn->query($qryn);

if ($mysqln->num_rows > 0)	
	{
	while($rown = $mysqln->fetch_assoc())	
		{
			$origbiddte = $rown['biddingdte'];
			$biddte = new DateTime($origbiddte);
			$biddte = $biddte->format('F d, Y');
			$descr = $rown['description'];
			$stat = $rown['bid_stat']; 

			$remarks = $rown['biddingrem']; 
			$createdby = $rown['createdby']; 
			$createdon = $rown['createdon']; 
			$modifiedby = $rown['modifiedby']; 
			$modifiedon = $rown['modifiedon']; 
		}
	}

if ($modifiedby != '') {
	$modmsg = 'Last modified by '.$modifiedby.' on '.$modifiedon;
}

if ($stat == '1') 
{
	$bidstat = "Active";
}
else
{
	$bidstat = "Inactive";
}
											

?>

<html  style="overflow-x: hidden;">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
		
	</head>
	<body>
					
		
				

			<?php	

			echo '
					<h2><a href="#" onClick="history.go(-1);">Back to list</a> > Edit Bidding '.$biddte.'</h2>
		

				 <form name="edititem" method="POST" action="bidedit_process.php">';
					echo '		<input type="hidden" name="bidid" value="'.$bidid.'" />
									
			 				
			 				<table id="addstock" >
								<tr class="head">
									<td> </td>
									<td>Old value </td>
									<td>New value </td>

								</tr>
								<tr>
									<td><label for="bidddate" >Bidding date<strong>*</strong></label></td>
									<td>
										<input type="text" name="biddte" value="'.$biddte.'" readonly>
									</td>
									<td>
										<input type="date" name="nw_biddte" value="'.$origbiddte.'" autofocus required>
									</td>
								</tr>
								
								<tr>
									<td><label for="desc">Description / Bidding Title</label></td>
									<td>
										<input type="text" name="descr" value="'.$descr.'" readonly >
									</td>
									<td>
										<input type="text" name="nw_descr" value="'.$descr.'" >
									</td>
								</tr>
								
								<tr>
									<td><label for="stat">Status <strong>*</strong></label></td>
									<td><select name="bidstat" readonly>';
										echo '<option value="'.$stat.'" selected> '.$bidstat.' </option>';
											
								  echo '</select>
									</td>
									<td><select name="nw_stat" >';
										echo '<option value="1" selected> Active </option>';
										echo '<option value="0"> Inactive </option>';
										
								  echo '</select>
									</td>
								</tr>
								<tr>
									<td><label for="Remarks">Remarks</label></td>
									<td><input type="text" name="remarks" value="'.$remarks.'" readonly></td>
									<td><input type="text" name="nw_remarks" value="'.$remarks.'"></td>
								</tr>
								
								<tr>
									<td colspan="3">Created by '.$createdby.' on '.$createdon.'</td>
								</tr>
								<tr>
									<td colspan="3">'.$modmsg.'</td>
								</tr>
								
								<tr >
									
									<td colspan="2">';
									echo '<br/>
										<button onClick="history.go(-1);">Cancel</button>
										<input type="submit" onClick="return confirm(\'Do you really want to modify the record for '.$biddte.' bidding ?\');">
									</td>
								</tr>
							</table>
						</form>';
							?>	

			

			<script src="js/angular.min.js"></script>		
	</body>
</html>