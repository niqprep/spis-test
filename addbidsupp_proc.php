<?php 

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	}

if (!isset($_POST['bidid']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: admin.php");
	} 
include 'database/dbconnect.php';
include 'functions.php';

$bidid = $_POST['bidid'];
$bidder = $_POST['bidder'];

//check for duplicate supplier
$chksupp = $conn->query("SELECT id from bidsupp where bid_id = '$bidid' and supp_id = '$bidder' ");
if ($chksupp->num_rows > 0) 
	{
		die("
			<script type=\"text/javascript\">
			alert(\"The supplier already exists. Please try again.\\n Thank you.\");
			history.go(-1);
			</script>
		");
	}
else
	{
		$userid = $_SESSION['userid'];
		$currdate = Date("Y-m-d H:i:s");
		$_SESSION['currentpage'] = "admin";
		$utype = $_SESSION['u_type'];
		$stat = $_POST['bidrstat'];
		$rem = $_POST['rem'];



		$qry06 = "INSERT into 
					bidsupp (
							bid_id,
							supp_id,
							createdby,
							createdon,
							status,
							remarks) 
					values(
							'$bidid',
							'$bidder',
							'$userid',
							'$currdate',
							'$stat',
							'$rem'
				)";
		$mysql06 = $conn->query($qry06);
		if ($mysql06)
		{
			echo '<script type="text/javascript">'; 
			echo 'alert("Successfully added the supplier for this bidding. \\n Thank you.");'; 
			echo 'history.go(-2);';
			echo '</script>';
		}
		else
		{
			die("<script type='text/javascript'>
				alert('Sorry! Something went wrong upon altering the database! Please try again later. \\n Thank you.');
				window.location.href = 'admin.php'
				</script>
			");

		}

	}



