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

//get bid details
$qryn = "SELECT  bid_id, biddingdte, description, bid_stat, biddingrem from bidding order by biddingdte desc, bid_stat desc, description asc";
$mysqln = $conn->query($qryn);

?>

<html  style="overflow-x: hidden;">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/styletab.css" rel="stylesheet" type="text/css" />
		
	</head>
	<body>
	<a href="addbidding.php" target="_top"> <i>Click here to add bidding information </i></a> <br>
					
					<table class="tblbid">
						<tr>
							<th >Bidding ID/Date</th>
							<th >Description / Title</th>
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
					
					$bidid = $rown['bid_id'];
					$biddte = new DateTime($rown['biddingdte']);
					$biddte = $biddte->format('F d, Y');
					
					$descr = $rown['description'];
					if ($rown['bid_stat'] == '1') 
					{
						$bidstat = "Active";
					}
					else
					{
						$bidstat = "Inactive";
					}
					
					$biddingrem = $rown['biddingrem'];
					
				

					echo '
					<tr ';
					//give id to tr for the row highlight. use modulo
					if ($modc % 2 != 0) 
					{
						echo 'id=trblue';
					}
					
					echo'>
					
					<td > '.$modc.'. '.$bidid.' <br><b>'.$biddte.'</b> </td>';
					$modc++;
					
					echo '
					<td >'.$descr .' </td>
					<td >'.$biddingrem .' </td>
					<td> '.$bidstat.' </td>
					<td><a href="bidview.php?bidid='.$bidid.'" title="View" target="_self"> <img src="images\icons\view3.png" id="utils" ></a>
						<a href="bidedit.php?bidid='.$bidid.'" title="Edit" target="_self"> <img src="images\icons\edit.png" id="utils" ></a>
						
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