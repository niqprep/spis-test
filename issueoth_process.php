<?php
session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "issuance";

//get user inputs from issueoth.php
$type = $_POST['type'];
$deptid = $_POST['deptid'];
$risno = $_POST['risno'];
$ctritems = count ($_POST['itemid']);

//loop through $itemid[] to get all values
$itemid = array();
if(isset($_POST['itemid']))
{
	if (is_array($_POST['itemid'])) 
	{
	    foreach($_POST['itemid'] as $value)
	    {
	      $itemid[] = $value;
	    }
	} 

}



//get the dept details
$qrydept = "SELECT * FROM itrmc_db01.dept where id = '$deptid' order by name asc ";
$resultdept = $conn->query($qrydept);

if ($resultdept->num_rows > 0)
{
	while($rowdept = $resultdept->fetch_assoc())
	{
		$deptname = $rowdept['name'];
		$deptdesc = $rowdept['description'];
	}
}

//get item details 
$item_name = array();
$desc = array();
$price = array();
$unit = array();
$bal = array();
for ($i=0; $i < $ctritems ; $i++) 
{ 
	$n = $itemid[$i];
	$qryitems = "SELECT * From itrmc_db01.othstocks 
				where othstocks.id = '$itemid[$i]'
				order by othstocks.item_name asc";
	$resultitems = $conn->query($qryitems);
	if ($resultitems->num_rows > 0)
	{
		while ($rowitem = $resultitems->fetch_assoc())
		{
			$item_name[] = ucwords(strtolower($rowitem['item_name']));
			$desc[] = $rowitem['desc'];
			$unit[] = $rowitem['unit'];

			//get the bal from non peri or peri tbl
			//first check nonperi
			$qrybal = "SELECT * from itrmc_db01.nonperi	where nonperi.stockid = $itemid[$i]";
			$resbal = $conn->query($qrybal);
			if ($resbal->num_rows > 0)
			{
				while ($rwbal = $resbal->fetch_assoc()) 
				{
					$bal[] = $rwbal['bal'];
				}
			}
			//if no results found, then check peri tbl
			else
			{
				$qrybal2 = "SELECT * from itrmc_db01.peri where peri.stockid = $itemid[$i]";
				$resbal2 = $conn->query($qrybal2);
				if ($resbal2->num_rows > 0) 
				{
					while ($rwbal = $resbal2->fetch_assoc()) 
					{
						$bal[] = $rwbal['bal'];
					}
				}

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
		<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
			<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>!-->
		<script type="text/javascript">
		    function load()
		    {
		        document.getElementById("issue").disabled=true;
		    }
		</script>
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
					$(id).css('top',  winH/2-$(id).height()/2);
					$(id).css('left', winW/2-$(id).width()/2);
				
					//transition effect
					$(id).fadeIn(1000); 	
				
				
			});

		</script>
	</head>
<body onload="load()">
	<div id="wholepage"">		
			<?php
				include 'header.php';
				$currdate = Date("M d, Y");
			
	echo '	<div id="mbody" ng-app="" ng-conroller="poCtrl" >
				
				<div id="boxes">
				<div id="dialog" class="window">
				Issued this '.$currdate.'
				<form name="issuedet" id="issueform" method="post" action="issue_process.php">
					<p>Department: '.$deptname.', '.$deptdesc.'   </p>
					<input type="hidden" name="deptid" value="'.$deptid.'" />
					<input type="hidden" name="risno" value="'.$risno.'" />
					RIS #: '.$risno.'
					
					<table id="record2">
						<tr id="heading2"> 
							<td> #</td>
							<td colspan="2">Item Description</td>
							<td> unit</td>
							<td> Avail Bal</td>
							<td> QTY</td>
							<td> New Bal</td>
						</tr>
					</table>';

				echo '	
					<div class="container">

						<input type="hidden" name="ctritems" value="'.$ctritems.'" />
						<input type="hidden" name="type" value="'.$type.'" />

						<table id="record3">';
							for ($i=0; $i < $ctritems; $i++) 
							{ 
								$no = 1+ $i;	
					echo '	<tr ng-init="bal'.$i.'='.$bal[$i].'"> 
								<td>
									
									<input type="hidden" name="itemid[]" value="'.$itemid[$i].'" />

									'.$no.'		
								</td>
								<td colspan="2">
									'.$item_name[$i].','.$desc[$i].'
								</td>
								<td> '.$unit[$i].'</td>
								<td >
									
									<input type="number" name="bal[]" ng-model ="bal'.$i.'" id="bal" readonly/>
								</td>
								<td >
									<input type="number" min="1" max="'.$bal[$i].'" name="qty[]" ng-model="qty'.$i.'" id="qty" required />
									
								</td>
								<td>
									<input type="text" name="newbal[]" id="amt" step="any" value="{{(bal'.$i.' - qty'.$i.')}}" disabled/>
								</td>
							</tr>';
								   		
								   	}	
				echo'	</table>				
					</div>

					';

	echo '			
					<input type="submit" value="Issue" />					<button onClick="history.go(-1);">Back</button>
				</form>
				</div> 
				
				<div id="mask"></div>
			</div>

				<div id="new">
					<h3> Issuance > House Keeping and Office Supplies </h3>
					<form id="srch" name="srch" method="post" action="issuehkofc_process.php" >
						<table id="srchelem"> 
							<tr>
								<td>Department:</td>
								<td><select name="deptid" > 
		';
									echo " <option value=''>".$deptname.", ".$deptdesc."</option>";

									  

								?>


									</select>
								</td>
								
							</tr>
							<tr>
								<td>Enter RIS #:</td>
								<td><input type="text" name="risno" id="risno" required /></td>
								<td><input type="submit" name="issue" id="issue" value="Issue" title="Issue items"></td>
								
							</tr>

						</table>
						<table id="record2">
							<tr id="heading2"> 
								<td>
									Select	
								</td>
								<td>
									#		
								</td>
								<td colspan="4">
									Description		
								</td>
								<td>
									Price		
								</td>
								<td >
									Unit	
								</td>
								<td colspan="2">
									Balance		
								</td>
								
								
							</tr>
						</table>
						<?php 
						echo '	
							<div class="container">
							   <table id="record">';
								   	
						echo'	</table>				
							</div>

						';

						?>
						
					</form>
					
				</div>
			
			</div>
			
	</div>
	<script src="js/angular.min.js"></script>									

</body>
</html>