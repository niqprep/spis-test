<?php
/*********************************************** 
* Script Name : pritemschk * 
* Scripted By : Monique Prepose * 
* Email : nicprep@ymail.com *
* Details: System checks the available qty that can be requested based from the selected ppmp's year and selected item 
***********************************************/ 
session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
$userid = $_SESSION['userid'];
include 'database/dbconnect.php';
include 'functions.php';
$_SESSION['currentpage'] = "po";
$currdate = Date("Y-m-d H:i:s");

if (!isset($_POST['logno']) AND !isset($_GET['djm']))
{
	header ("location: po.php");
}
elseif(isset($_POST['logno']))
{
	$logno = $_POST['logno'];
	$prno = cleanthis($_POST['prno']);
	$prdte = $_POST['prdte'];
	$sectid = $_POST['sectid'];
	$reqby = $_POST['reqby'];
	$appby = $_POST['appby'];
	$appdte = $_POST['appdte'];
	$sectname = $_POST['sectname'];
	$catid = $_POST['catid'];
	$ppmpyrid = $_POST['ppmpyrid'];
	$purpose = cleanthis($_POST['purpose']);
	$ppmpid = cleanthis($_POST['ppmpid']);

	$yr = array_values(mysqli_fetch_array($conn->query("SELECT year from ppmpyr where id = '$ppmpyrid'")))[0];

	//get item details
	$items = array(); //ppmp item id
	$ppmpitemid = array();
	$ppmpitemqty = array();
	$itemname = array();
	$idesc = array();
	$itemid = array();
	$qtys = array();
	$totalpr = array();
	$availppmpqty = array();
	$nopr = array();
	for ($i=0; $i < $logno ; $i++) 
	{ 
		$itema = "item".$i;
		$items[$i] = $_POST[$itema];
		list($ppmpitemid[$i], $ppmpitemqty[$i], $itemname[$i], $idesc[$i], $itemid[$i]) = explode("*", $items[$i]); 
		$qtya = "qty".$i;
		$qtys[] = $_POST[$qtya]; //pr qty

		$totalpr[$i] = array_values(mysqli_fetch_array($conn->query("SELECT sum(pr_items.pr_qty)
					FROM ppmp_items left outer join pr_items on ppmp_items.itemid = pr_items.itemid
					left outer join pr on pr_items.pr_id = pr.id									
					where (year(pr.prdate) = '$yr')   and  ppmp_items.id = '$ppmpitemid[$i]'")))[0]; //get the total PR'd qty for the PPMP year of the  specified item
		if ($totalpr[$i] == '') 
		{
			$totalpr[$i] = 0;
		}
		$totalpr[$i];
		$availppmpqty[$i] = $ppmpitemqty[$i] - $totalpr[$i];
		//echo "</br></br>";
		if($availppmpqty[$i] < $qtys[$i])
		{
			$nopr[$i] = $itemname[$i].' '.$idesc[$i];
		}

	}

	if(count($nopr) > 0)
	{
		//if there are items that have exceeded their ppmp
		echo '<script type="text/javascript">'; 
		echo 'alert("The following items for '.$sectname.' have exceeded their '.$yr.' PPMP.\\n '.implode(",\\n", $nopr).' \\n Please try again. Thank you.");'; 
		echo 'history.go(-2);';
		echo '</script>';
	}
	else
	{	
		//save pr information
		$qry06 = "START TRANSACTION";
		$sqlstart = $conn->query($qry06);
		$qrypr ="INSERT into 
						pr(		pr_no, prdate, prcat, section, reqby, purpose, approvedby, approved, createdby, created, status) 
						VALUES (
								'$prno', '$prdte', '$catid', '$sectid', '$reqby', '$purpose', '$appby', '$appdte', '$userid', '$currdate', '1');
				";
		$mysqlpr = $conn->query($qrypr);
		if(!$mysqlpr)
		{
			//rollback CHANGES
			$qryroll = "ROLLBACK;";
			$mysqlroll = $conn->query($qryroll);
			echo '<script type="text/javascript">'; 
			echo 'alert("Something went wrong in logging the PR.\\n Please try again. Thank you.");'; 
			echo 'history.go(-2);';
			echo '</script>';
		}
		else
		{	
			$getprid = "SET @prid = LAST_INSERT_ID(); ";//get the id of the recently created pr 
			$mysqlpri= $conn->query($getprid);

			for ($i=0; $i < $logno; $i++)
			{ 
				$qrypritems = "INSERT into 
							pr_items(	
									pr_id, itemid, pr_qty, pritem_stat, createdby, createdon ) 
							VALUES (
									@prid, '$itemid[$i]', '$qtys[$i]', '1', '$userid', '$currdate');";
				$mysqlpritems = $conn->query($qrypritems);
				
				
			}
			if ($mysqlpritems) 
			{
				$qrycom = "COMMIT;";
				$mysqlcom= $conn->query($qrycom);
				/*echo 'good';*/
				if($mysqlcom)
				{
					echo '<script type="text/javascript">'; 
					echo 'alert("PR information are added successfully.\\n I will now direct you to the creation of Purchase Order. Thank you.");'; 
					//echo 'window.location.href = "searchpo.php"';
					echo '</script>';
				}
			}		
		}
	}
}
elseif (isset($_GET['djm']))
{
	$prid = cleanthis($_GET['djm']);
	$prno = cleanthis($_GET['niq']);
}
/*********************************************** 
* Details: Select bidding date before creating Purchase Order 
***********************************************/ 

$qrycat = "SELECT distinct(biddingdte) FROM bidding where bid_stat = '1' order by biddingdte asc ";
$resultcat = $conn->query($qrycat);
$biddte = array();
$ctrcat = 0;
if ($resultcat->num_rows > 0)
{
	while($rowcat = $resultcat->fetch_assoc())
	{
		$biddte[] = $rowcat['biddingdte'];
			
		$ctrcat++;
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
	<div id="wholepage">		
		<?php
			include 'header.php';
		
		
			echo '<div id="boxes">';
				echo '<div id="dialog" class="window">';
					echo '<ul>
								 	<li><a href="index.php" title="Go to Home page">Dashboard</a></li>|
								 	<li><a href="searchpo.php"  title="Manage PO">Manage PO</a></li>|
								 	<li><a href="admin.php"  title="Add bidding date">Add New Bidding</a></li>
								</ul>';	
					echo '<form name="rcv" id="rcv" method="POST" action="issuehkofc.php">	';		
						
						echo '<div >
							<h2>Select bidding for PR No. '.$prno.'</h2>
								<table id="potbls">
									<tr>
										<td>Bidding Date</td>
										<td>Bidding Description</td>
										
									</tr>
								</table>

								<div id="leftdiv">
									<table>';
										for ($i=0; $i < $ctrcat; $i++)
										{ 
											$biddte2 = new DateTime($biddte[$i]);
											$biddte2 = $biddte2->format('F d, Y');
											echo '<tr><td><a href="bidlistframe.php?date='.$biddte[$i].'&prno='.$prno.'" target="newpo">'.$biddte2.'</a></td></tr>';	
										}
							echo '	</table>
								</div>
								<div id="middiv" >
									<iframe name="newpo" frameborder="0" src=""> </iframe>';
									
							echo'</div>
								
							</div>';
						
					echo '</form>';
				echo '</div> ';
				
				echo '<div id="mask"></div>';
			echo '</div>';

		echo '<div id="mbody">';
		
			echo '<div id="mc_rcv1">';
				echo '<h2>Create Purchase Order</h2>';
				
			echo '</div>';
		
		echo '</div>';
		
			include 'footer.php';
		?>
	</div>
<script src="js/angular.min.js"></script>									

</body>
</html>

