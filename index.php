<?php
session_start();

//check user
if (!isset($_SESSION['username']))
{
	//print "<script> alert('You Failed to Log In')</script>";
	header ("location: logform.php");
} 
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "dashboard";

$item = array();
$desc = array();
$unit = array();
$bal = array();
$ctr = 0;

$sql ="SELECT * FROM stocks inner join nonperi on stocks.id = nonperi.stockid 
		where s_status = 'Active' and bal <= rlvl order by bal asc, item_name asc, `desc` asc";
$result = $conn->query($sql);
if ($result-> num_rows > 0) 
{
	while ($row = $result->fetch_assoc()) 
	{
		$item[] = $row['item_name'];
		$desc[] = $row['desc'];
		$unit[] = $row['unit'];
		$bal[] = $row['bal'];
		$id[] = $row['id'];
		$ctr++;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		
	</head>
<body>
	<div id="wholepage"">
		<?php
			include 'header.php';
		echo '
		<div id="mbody">
		
			<div id="submenu">
			</div> 
			<div id="maincontent">
				<div id="poimg">
					<a href="issuehkofc.php?cat=HK" ><img src="images/issue.png" alt="Log PO and RIS" /> </a>
					<p> Issuance of <b>House Keeping</b> Supplies. </p>
				</div>
				<div id="poimg">
					<a href="issuehkofc.php?cat=OS" ><img src="images/issue.png" alt="Log PO and RIS" /> </a>
					<p> Issuance of <b> Office Supplies</b>. </p>
				</div>
				<div id="poimg">
					<a href="po.php" ><img src="images/po.png" alt="" /> </a>
					<p> Create Purchase orders and RIS.</p>
				</div>
				<div id="poimg">
					<a href="rcvpo.php" ><img src="images/rcv.png" alt="" /> </a>
					<p>Receive purchase orders or deliveries.</p>
				</div>
				<div id="poimg">
					<a href="#" ><img src="images/reports.png" alt="Create Reports" /> </a>
					<p> Create differedsadasdasdnt kinds of reports. Convert and download them into excel files.</p>
				</div>
				
				
				
			</div>
		<div id="lowernav">	
			<div id="lowernav1">
					<div id="noti">
						<strong>LOW ON STOCK</strong> <!--House keeping and Office supplies only --!>
						<div id="notibubble"> '.$ctr.'</div>

					</div>
					<div id="list">
						<table><ul>';		
						
						for ($i=0; $i < $ctr; $i++) 
						{
							$item1 = $item[$i].', '.$desc[$i];
							$item1 = ucwords(strtolower($item1));
							echo '<tr><td><a href="dbmps.php?id='.$id[$i].'" target="_t"> '.$item1.' </td><td>'.$bal[$i].' '.$unit[$i].'/s </a></td></tr>';
							#
						}
									
				echo '</ul></table>
					</div>	
			</div>	
		</div>	
			
		
		</div>';
		
		
			include 'footer.php';
		
	echo '</div>
</body>
</html>';