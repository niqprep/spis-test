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

if (!isset($_GET['cat']))
{
	if (!isset($_POST['cat']))
	{
		header ("location: issueselect.php");	
	}
	else
	{
		$cat = $_POST['cat'];
	}
}
else
{
	$cat = $_GET['cat'];
}

//get all departments list
$qrydept = "SELECT * FROM itrmc_db01.dept order by name asc ";
$resultdept = $conn->query($qrydept);
$deptid = array();
$deptname = array();
$deptdesc = array();
$ctrdept = 0;
if ($resultdept->num_rows > 0)
{
	while($rowdept = $resultdept->fetch_assoc())
	{
		$deptid[] = $rowdept['id'];
		$deptname[] = $rowdept['name'];
		$deptdesc[] = $rowdept['description'];
		$ctrdept++;
	}
}

//get all items
$stockid = array();
$item_name = array();
$desc = array();
$price = array();
$unit = array();
$bal = array();
$ctritem = 0;
$qryitems = "SELECT * From itrmc_db01.stocks 
			inner join itrmc_db01.nonperi on stocks.id = nonperi.stockid
			where (stocks.category = '".$cat."') and stocks.s_status = 'Active'
			order by stocks.item_name asc, stocks.desc asc";
$resultitems = $conn->query($qryitems);
if ($resultitems->num_rows > 0)
{
	while ($rowitem = $resultitems->fetch_assoc())
	{
		$stockid[] = $rowitem['id'];
		$item_name[] = ucwords(strtolower($rowitem['item_name']));
		$desc[] = $rowitem['desc'];
		$price[] = 'P '.number_format($rowitem['purchase_price'], 2);
		$unit[] = $rowitem['unit'];
		$bal[] = $rowitem['bal'];
		$ctritem++;
	}
}

$ris = date("ymd-His");



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
	</head>
<body onload="load()">
	<div id="wholepage"">		
			<?php
				include 'header.php';
			?>
			<div id="mbody">
				
				
				<div id="new">
					<h3> Issuance > 
					<?php
						switch ($cat) {
							case 'OS':
								echo "Office Supplies ";
								break;
							case 'HK':
								echo "House Keeping Supplies";
								break;
							default:
								echo "House Keeping and Office Supplies";
								break;
						}
					?></h3>
					<form id="srch" name="srch" method="post" action="issuehkofc_process.php" >

						<table id="srchelem"> 
							<tr>
								<td>Section / Dept:</td>
								<td><select name="deptid" required autofocus >
									 <option value=""> </option>
									  <?php

									  for($ctr=0; $ctr < $ctrdept; $ctr++)
									  {
									  	echo " <option value='".$deptid[$ctr]."'>".$deptname[$ctr].", ".$deptdesc[$ctr]."</option>";

									  }

									  

									  echo '
									</select>
								</td>
								
							</tr>
							<tr>
								<td>RIS #:</td>
								<!--<td><input type="text" name="risno" id="risno" value="R'.$ris.'" readonly/></td>!-->
								<td><input type="text" name="risno" id="risno" required /></td>
								<td><input type="submit" name="issue" id="issue" value="Issue" title="Issue items"></td>
								
							</tr>';
									?>
						</table>
						<table id="issueth">
							<tr > 
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
								   	for ($i=0; $i < $ctritem; $i++) { 
								   		$no = 1+ $i;	
									   	echo '<tr> 
												<td>
													<input type="hidden" name="type" value="hkos" />';
													if($bal[$i] < 1)
													{
														echo '<input type="checkbox" name="itemid[]" value="'.$stockid[$i].'" disabled/>';
														echo '</td>
																<td>
																	'.$no.'		
																</td>
																<td colspan="4">
																	<strong style="color:red; font-size: 14px;">'.$item_name[$i].', '.$desc[$i].'</strong>		
																</td>
																<td>
																	'.$price[$i].'		
																</td>
																<td >
																	'.$unit[$i].'	
																</td>
																<td colspan="2">
																	<strong style="color:red; font-size: 14px;">'.$bal[$i].'</strong>	
																</td>';
													}
													else
													{
														echo '<input type="checkbox" name="itemid[]" value="'.$stockid[$i].'"/>';
														echo '</td>
															<td>
																'.$no.'		
															</td>
															<td colspan="4">
																'.$item_name[$i].', '.$desc[$i].'	
															</td>
															<td>
																'.$price[$i].'		
															</td>
															<td >
																'.$unit[$i].'	
															</td>
															<td colspan="2">
																'.$bal[$i].'	
															</td>';
													}
										echo  '</tr>';
								   		
								   	}	
						echo'	</table>				
							</div>

						';

						?>
						
					</form>
					
				</div>
			
			</div>
			
			<?php
				include 'footer.php';
			?>
	</div>
	<script type="text/javascript">
		var checkboxes = $("input[type='checkbox']"),
		    submitButt = $("input[type='submit']");

		checkboxes.click(function() {
		    submitButt.attr("disabled", !checkboxes.is(":checked"));
		});
		
	</script>

	<script src="js/angular.min.js"></script>									

</body>
</html>