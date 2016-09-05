<?php
//start the session
session_start();

//connect to the supply_db
include 'database/dbconnect.php';

//get username and password from the logform.php, from POST method
htmlspecialchars(strip_tags(trim($_POST['username'])));
$username = mysql_real_escape_string($_POST['username']);
$pw = mysql_real_escape_string($_POST['password']);





//CHECK HASH  
/*$hash_pw = array_values(mysqli_fetch_array($conn->query("SELECT pword FROM user WHERE uname='$username'")))[0];

if (password_verify($pw, $hash_pw)) 
{
    header("location: index.php");
}
else 
{
   	$message = "Username and/or Password incorrect.\\nTry again.";
	echo"<script>alert('$message');
	history.go(-1);</script>";
}*/


/*//CHECK HASH  
$hash_pw = array_values(mysqli_fetch_array($conn->query("SELECT pword FROM user WHERE uname='$username'")))[0];

if (password_verify($pw, $hash_pw)) 
{
    header("location: index.php");
}
else 
{
   	$message = "Username and/or Password incorrect.\\nTry again.";
	echo"<script>alert('$message');
	history.go(-1);</script>";
}




*/









//retrieve user's list from the db with the same username and password
$qry = "SELECT * FROM user WHERE uname='$username' AND pword='$password'";
$result = $conn->query($qry);

//correct login credentials
if ($result->num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		//get the user's info from db and assign to the variables for system use
		$username= $row['uname'];
		$usertype= $row['u_type'];
		$userid = $row['id'];
		
		$_SESSION['username'] = $username;
		$_SESSION['u_type'] = $usertype;
		$_SESSION['userid'] = $userid;
		//echo $password;
		header("location: index.php");
	}
}


$pw = password_hash($password, PASSWORD_DEFAULT);
echo $pw

//incorrect login credentials
else
{
	
	$message = "Username and/or Password incorrect.\\nTry again.";
	echo"<script>alert('$message');
	history.go(-1);</script>";
}
?>