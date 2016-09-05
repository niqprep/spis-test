<?php
//start the session
session_start();

//connect to the supply_db
include 'database/dbconnect.php';

//get username and password from the logform.php, from POST method
htmlspecialchars(strip_tags(trim($_POST['username'])));
$username = mysql_real_escape_string($_POST['username']);
$pw = mysql_real_escape_string($_POST['password']);

//retrieve user's list from the db with the same username and password
$qry = "SELECT * FROM user WHERE uname='$username'";
$result = $conn->query($qry);

//correct login credentials
if ($result->num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		//get the user's info from db and assign to the variables for system use
		$_SESSION['username']= $row['uname'];
		$_SESSION['u_type']= $row['u_type'];
		$_SESSION['userid'] = $row['id'];
		$hash_pw = $row['pword'];
		
		//check hash
		if (password_verify($pw, $hash_pw)) 
		{
		    header("location: index.php");
		}
		else 
		{
		   	$message = "Username and/or Password mismatch.\\nTry again.";
			echo"<script>alert('$message');
			history.go(-1);</script>";
		}

	}
}

//incorrect USERNAME 
else
{
	
	$message = "Incorrect credentials, please try again.\\nThank you.";
	echo"<script>alert('$message');
	history.go(-1);</script>";
}
?>