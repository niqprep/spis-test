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

/*if (!isset($_GET['djm']) or !isset($_GET['mpp']) or !isset($_GET['<3']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: searchpo.php");
	} 
$poid = $_GET['djm'];
$pono = $_GET['mpp'];
$proc = $_GET['<3'];

$qrypoamt = "SELECT poamount FROM purchase_order where po_number = '$pono'";
$mysqlpoamt = $conn->query($qrypoamt);
if($mysqlpoamt->num_rows > 0)
{
	while($rowamt = $mysqlpoamt->fetch_assoc())
	{
		$poamt = $rowamt['poamount'];
	}
}

$suppctr = 0;
$lname = array();
$fname = array();
$mname = array();
//inner join po, supplier, agentprof, profile tables
$qry06 = "SELECT * FROM purchase_order
			left outer join supplier on purchase_order.supplierid = supplier.id
			left outer join agentprof on supplier.id = agentprof.companyid
			left outer join profile on  agentprof.profileid = profile.id 
		where purchase_order.id = $poid";
$mysql06 = $conn->query($qry06);
if ($mysql06->num_rows > 0)
{
	while($row06 = $mysql06->fetch_assoc())
	{
		$fname[] = ucfirst_sentence($row06['fname']);
		$lname[] = ucfirst_sentence($row06['lname']);		
		$mname[] = ucfirst_sentence($row06['mname']);
		$agentprofid[] = $row06['agentprof_id'];
		$suppctr++;
	}     
}*/
			
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
				
				//if close button is clicked
				//$('.window .close').click(function (e) {
				//	//Cancel the link behavior
				//	e.preventDefault();
				//	
				//	$('#mask').hide();
				//	$('.window').hide();
				//});		
				
				//if mask is clicked
				//$('#mask').click(function () {
				//	$(this).hide();
				//	$('.window').hide();
				//});
			});
			
		</script>
	</head>
<body>
		
		<?php
			include 'header.php';
			$currdate = Date("Y-m-d H:i:s");
			$currdate2 = Date("Y-m-d");

			echo '<div id="boxes">
					<div id="dialog" class="window">';

				
						echo'	<p>Add new bidding information<i> </i></p>
									
									<form name="logno" id="rcv" method="post" action="process_addbid.php">
											
											<table id="popuptbl" >
												<tr> 
													<td >Bidding Title</td>

													<td><input type="text" name="biddesc" id="datetime" placeholder="Enter bidding title/description" autofocus required></td>
													
												</tr>
												<tr> 
													<td >Bidding date </td>
													<td ><input type="date" name="biddate" id="datetime" value="'.$currdate2.'" placeholder="Bidding date"  required /></td>
												</tr>
												<tr> 
													<td >Bidding Status</td>
													<td >
														<select name="bidstat" id="datetime" autofocus required>
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
												<input type="submit" value="Proceed" />
												<button onClick="history.go(-1);">Back</button>
											</div>
									</form>';

					echo '</div> 
					
				<div id="mask"></div>';
		?>

		<div id="mbody">
		<h2> Administrator Operations</h2>
			<div id="tabs-container">
 				
				<ul class="tabs-menu">
			  
					<li class="current"><a href="#tab-1">Bidding</a></li>
			  
					<li><a href="#tab-2">Items</a></li>
			  
					<li><a href="#tab-3">Users</a></li>
			  
					<li><a href="#tab-4">Other Providers</a></li>
			 
					<li><a href="#tab-5">My Account</a></li>
			 
				</ul>
				<div class="tab">
			 
					<div id="tab-1" class="tab-content">
					Add bidding data<br>
					<table class="tblframe">
						
					</table>
					<iframe src="" name="newpo" frameborder="0" ></iframe>
			 		</div>

			  		<div id="tab-2" class="tab-content">
			  		
					</div>
					  
					<div id="tab-3" class="tab-content">
					
			 		</div>
			  
					<div id="tab-4" class="tab-content">
						
					</div>

					<div id="tab-5" class="tab-content">
					
					</div>
			  
				</div>
			</div>
		</div>
		
		<?php
			include 'footer.php';
		?>


</body>
</html>