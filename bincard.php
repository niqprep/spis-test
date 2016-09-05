<?php

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "view";

if (!isset($_GET['cat']))
{
	header("location: selcat3.php");
}
else
{
	$cat = $_GET['cat'];
}


?>


<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
		
	</head>

<body >

<?php
echo '<div id="wholepage">
';		

			include 'header.php';

echo '<div id="mbody">
			<div id="submenu">
			</div>
			
				<div id="mc_rcv">
					<h2>';

				switch ($cat) {
					case 'HK':
						echo 'House Keeping';
						break;
					case 'OS':
						echo 'Office Supplies';
						break;
					
					default:
						# code...
						break;
				}

				echo '</h2>
				<form id="poform" name="POForm2" method="POST" action="bin_frame.php" target="binframe">
					<div id="tablediv2">	
							<table id="tablesearch" >
								<tr>
									<td colspan="2"> <input type="text" name="searchtxt" id="searchtxt" placeholder="Enter Item\'s name/description here" autofocus/></td>
									<td> <input type="submit" name="searchbtn" id="searchbtn" value="Search" title="Search"></td>
									<input type="hidden" name="catg" value="'.$cat.'"/>
								</tr>
								
							</table>
				</form>
						<div id="search">
							 <table id="record">';
								   		echo '<tr> 
										   			<td>
													#|BinCard|Edit|Delete
													</td>
													
													<td colspan="4" id="num">
														Item Description
													</td>
													
													<td colspan="1" id="num">
														Avail Stock	
													</td>
													<td colspan="1" id="num">
														Unit
													</td>

											 </tr>
							 </table>';
							echo '				 
							<iframe src="bin_frame.php?cat='.$cat.'" name="binframe" frameborder="0" ></iframe>	
					
						</div>
					</div>
					
				</div>

			<div class="buttons">

			</div>
	</div>
	';
		
		
			include 'footer.php';
?>

</div>

<script src="js/angular.min.js"></script>									

</body>
</html> 
