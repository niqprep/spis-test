<?php

session_start();

//check user
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 	
include 'database/dbconnect.php';
$_SESSION['currentpage'] = "supplier";
$userid = $_SESSION['userid'];
$utype = $_SESSION['u_type'];
$currdate = Date("Y-m-d h:i:s A");


echo '<form name="import" method="post" enctype="multipart/form-data">';
    	echo '<input type="file" name="file" /><br />';
        echo '<input type="submit" name="submit" value="Submit" />';
echo '</form>';

//get the data from the csv and save it in array
if(isset($_POST["submit"]))
{
	echo $filename=$_FILES["file"]["tmp_name"];
	if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r") or die("Problem open file");
        $count = 0;
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {
        	$count++;//added to skip 1st row of data from csv
        	if($count>1)
        	{
        		$sql = "INSERT into bidsupp
        							(bid_id, supp_id, status, remarks, createdby, createdon) 
            				values 	('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]', '$userid', '$currdate')";
            	$mysql = $conn->query($sql);


        	}
            
        }
        fclose($file);
        if($mysql)
        {
			echo ' CSV File has been successfully Imported';
        	//header('Location: index.php');
		}
		else
		{
			echo "Sorry! There is some problem.";
		}
    }
    else
        echo 'Invalid File:Please Upload CSV File';
}