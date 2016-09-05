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
	header ("location: selcat2.php");
}

$cat = $_GET['cat'];
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
$qryitems = "SELECT * From itrmc_db01.othstocks 		
			where othstocks.s_status = 'Active' and category = '$cat'
			order by othstocks.item_name asc, othstocks.desc asc";
$resultitems = $conn->query($qryitems);
if ($resultitems->num_rows > 0)
{
	while ($rowitem = $resultitems->fetch_assoc())
	{
		$stockid[] = $rowitem['id'];
		$item_name[] = ucwords(strtolower($rowitem['item_name']));
		/*$item_name[] = $rowitem['item_name'];*/
		$desc[] = $rowitem['desc'];
		$price[] = 'P '.number_format($rowitem['purchase_price'], 2);
		/*$price[] = $rowitem['purchase_price'];*/
		$unit[] = $rowitem['unit'];
		
		$stockid01 = $stockid[$ctritem];
		//search in nonperi
		$qrynon = "SELECT * From itrmc_db01.nonperi where nonperi.stockid = $stockid01";
		$result = $conn->query($qrynon);
		if ($result->num_rows > 0)
		{
			while ($row01= $result->fetch_assoc())
			{
				$bal[] = $row01['bal'];
			}	 
		}
		else //if not existing in nonperi, search in peri
		{
			$qryper = "SELECT * From itrmc_db01.peri where peri.stockid = $stockid01";
			$result = $conn->query($qryper);
			if ($result->num_rows > 0)
			{
				while ($row01= $result->fetch_assoc())
				{
					$bal[] = $row01['bal'];
				}	 
			}
		}

		$ctritem++;
	}
}
else
{
	echo '<script type="text/javascript">'; 
	echo 'alert("There are no items in the inventory yet.\\n Thank you!");'; 
	echo 'window.location.href = "selcat2.php";';
	echo '</script>';
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
			
			echo '
			<div id="mbody">
				
				
				<div id="new">
					<h3> Issuance > Other Supplies </h3>
					<form id="srch" name="srch" method="post" action="issueoth_process.php" >
						<table id="srchelem"> 
							<tr>
								<td>Department:</td>
								<td><select name="deptid" >';
									 
									

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
								<td><input type="text" name="risno" id="risno" value="R'.$ris.'" required /></td>
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
							<input type="hidden" name="type" value="'.$cat.'" />
							   <table id="record">';
								   	for ($i=0; $i < $ctritem; $i++) { 
								   		$no = 1+ $i;	
									   	echo '<tr> 
												<td>
													';
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