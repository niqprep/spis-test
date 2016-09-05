<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/loginstyle.css" rel="stylesheet" type="text/css" />
	</head>
<body>
	<div id="logform"">
		<img src="images/loginlogo.png" alt="ITRMC" />
		<form name="LoginForm" method="post" action="process_login.php">
			<div>
				<label for="username"> Username: </label>
				<input type="text" name="username" id="username" placeholder="Type your username here" autofocus />
			</div>
			<div>
				<label for="password"> Password: </label>
				<input type="password" name="password" />
			</div>	
			<div>
				<input type="hidden" name="logtimes" value="1" />
				<input type="submit" value="Log In" />
			</div>
		</form>
		
		<p> 
		Copyright &#169; 2015, ITRMC - HOMIS 
		</p>
			
	</div>

</body>
</html>