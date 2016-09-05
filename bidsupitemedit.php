<?php 
session_start();

if (!isset($_SESSION['username']))
{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
} 

include 'functions.php';
include 'database/dbconnect.php';


if (!isset($_GET['bidsuppid']))
{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: admin.php");
} 
else
{
	$bidsuppid = $_GET['bidsuppid'];
}

$userid = $_SESSION['userid'];
$utype = $_SESSION['u_type'];


//get bid details
$qryn = "SELECT biddingdte, description, status,
				bidsupp.remarks, 
				bidsupp.modifiedby, 
				bidsupp.modifiedon, 
				bidsupp.createdby,
				bidsupp.createdon,
				supplier.name,
				bidsupp.supp_id

		from bidding left outer join bidsupp on bidsupp.bid_id = bidding.bid_id 
					left outer join supplier on bidsupp.supp_id = supplier.id 
		where bidsupp.id = '$bidsuppid' ";
$mysqln = $conn->query($qryn);

if ($mysqln->num_rows > 0)	
	{
	while($rown = $mysqln->fetch_assoc())	
		{
			$origbiddte = $rown['biddingdte'];
			$biddte = new DateTime($origbiddte);
			$biddte = $biddte->format('F d, Y');
			$descr = $rown['description'];
			$stat = $rown['status']; 

			$remarks = $rown['remarks']; 
			$createdby = $rown['createdby']; 
			$createdon = $rown['createdon']; 
			$modifiedby = $rown['modifiedby']; 
			$modifiedon = $rown['modifiedon']; 

			$suppname = $rown['name'];
			$suppbidstat = $rown['status'];

			$suppid = $rown['supp_id'];

		}
	}

if ($modifiedby != '') {
	$modmsg = 'Last modified by '.$modifiedby.' on '.$modifiedon;
}

$bidstat = chkactive($suppbidstat);

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

			
			echo '<h2><a href="admin.php" target="_top">Back to Bidding List </a> > <a href="" onClick="history.go(-1);">Back to Supplier list</a> > Edit Bidding/Supplier Info</h2>';
			echo $biddte.' - '.$descr.' - '.strtoupper($suppname).'<br><br>';
		

			echo '	 <form name="edititem" method="POST" action="bidsupitemedit_process.php">';
					echo '		<input type="hidden" name="bidsuppid" value="'.$bidsuppid.'" />';
					echo '		<input type="hidden" name="suppid" value="'.$suppid.'" />
									
			 				
			 				<table id="addstock" >
								<tr class="head">
									<td> </td>
									<td>Old value </td>
									<td>New value </td>

								</tr>
								<tr>
									<td><label for="suppname" >Supplier<strong>*</strong></label></td>
									<td>
										<input type="text" name="suppname" value="'.ucfirst($suppname).'" readonly>
									</td>
									<td>
										<input type="text" name="nw_suppname" value="'.ucfirst($suppname).'" autofocus readonly>
									</td>
								</tr>
								
								
								
								<tr>
									<td><label for="stat">Status <strong>*</strong></label></td>
									<td><select name="bidstat" readonly>';
										echo '<option value="'.$suppbidstat.'" selected>'.$bidstat.'</option>';
											
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
									<td></td>
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