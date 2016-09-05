<?php

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "admin";


$currdate = Date("Y-m-d");

$idemp = array();
$lname = array();
$fname = array();
$mname = array();
$ctr = 0;
$sql = "SELECT * from empprof inner join profile on empprof.profileid = profile.id
		where profile.status = 'Active' order by lname asc, fname asc";
$result = $conn->query($sql);
if ($result -> num_rows > 0) 
{
	while($row = $result-> fetch_assoc())
	{
		$idemp[] = $row['id'];
		$lname[] = $row['lname'];
		$fname[] = $row['fname'];
		$mname[] = $row['mname'];
		$ctr++;
	}
}



echo '<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>SPIS - Add New Section</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
	</head>
<body>
<div id="wholepage">
';	
			include 'header.php';
echo '<div id="mbody"><i id="title"><a href="dept.php">Proceed to Section\'s List</a> </i>
			<h2> Add New Section </h2>
			<form name="additem" method="POST" action="adddept_process.php"> 
				<table id="addstock">
					<tr>
						<td><label for="item">Section Name<strong>*</strong></label></td>
						<td>
						<input type="text" name="name" placeholder="e.g. Human Resource, Cashier" title="e.g. Human Resource, Cashier" required>
						</td>
					</tr>
					<tr>
						<td><label for="item">Section Head<strong>*</strong></label></td>
						<td>
							<select name="head" >'; 
								for ($i=0; $i < $ctr; $i++) 
								{ 
									$name = $lname[$i].", ".$fname[$i]." ".$mname[$i];
									$name = ucwords(strtolower($name));
									echo '<option value="'.$idemp[$i].'">'.$name.'</option>';

								}

							echo '
					  		</select>
						</td>
					</tr>
					<tr>
						<td><label for="desc">Division/Department <strong>*</strong></label></td>
						<td>';
						
							//enter a description for the new department
							echo '
							<select name="sectdesc" >
								<option value="Administrative Division"> Administrative Division </option>
								<option value="Ancillary Division"> Ancillary Division </option>
								<option value="Finance Division"> Finance Division </option>
								<option value="Medical Center Chief"> Medical Center Chief Office</option>
								<option value="Medical Division"> Medical Division </option>
								<option value="Nursing Division"> Nursing Division </option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td><label for="stat">Status <strong>*</strong></label></td>
						<td><select name="stat" >
								<option value="1"> Active </option>
								<option value="0"> Inactive </option>';

					  echo '</select>
						</td>
					</tr>
					<tr>
						<td><label for="Remarks">Remarks</label></td>
						<td><textarea name="remarks" ></textarea></td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit">
						</td>
					</tr>
				</table>
			</form>
	  </div>';	
			include 'footer.php';
?>

</div>

<script src="js/angular.min.js"></script>									

</body>
</html> 
