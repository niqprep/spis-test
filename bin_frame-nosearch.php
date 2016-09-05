<?php 

session_start();
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
include 'database/dbconnect.php';


if (isset($_GET['cat']))
{
	$cat = $_GET['cat'];
	if ($cat == 'HK') 
	{
		$qry = "SELECT * FROM itrmc_db01.stocks 
		INNER JOIN itrmc_db01.nonperi on stocks.id = nonperi.stockid
		where stocks.s_status = 'Active' and (stocks.category = 'HK')
		order by stocks.item_name asc, `desc` asc";
	}
	elseif ($cat == 'OS')
	{
		$qry = "SELECT * FROM itrmc_db01.stocks 
		INNER JOIN itrmc_db01.nonperi on stocks.id = nonperi.stockid
		where stocks.s_status = 'Active' and (stocks.category = 'OS')
		order by stocks.item_name asc, `desc` asc";
	}
	else
	{
		echo '<script type="text/javascript">'; 
   		echo 'alert("Category or Item\'s information is incorrect.\\n Please try again.");'; 
    	echo 'window.location.href = "selcat3.php";';
     	echo '</script>';
	}

}
elseif (isset($_POST['cat']))
{
	echo "heloo";
}
else
{
	header("location: selcat3.php");
}


$stockid = array();
$item = array();
$desc = array();
$brand = array();
$unit = array();
$bal = array();
$ctr = 0;
$result = $conn-> query($qry);
if ($result-> num_rows > 0)
{
	while ($row = $result -> fetch_assoc()) 
	{
		$stockid[] = $row['id'];
		$item[] = ucwords(strtolower($row['item_name']));
		$desc[] = ucfirst($row['desc']);
		$brand[] = ucfirst($row['brand']);
		$unit[] = $row['unit'];
		$bal[] = $row['bal'];
		$ctr++;
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
		
	</head>

<body >

<?php 
echo '<div class="container2">

							   <table id="record">';
							   		

								   	for ($i=0; $i < $ctr; $i++)
								   	{ 
								   		$no = 1+ $i;	
									   	echo '<tr> 
									   			<td>
													'.$no.'. 
													<a href="select.php?std='.$stockid[$i].'" target="_blank"><img src="images/bin.jpg" id="icon" title="view bin card" /> </a>	
													<a href="edit_item.php?std='.$stockid[$i].'&cat='.$cat.'" target="_parent"><img src="images/edit.png" id="icon" title="edit" /> </a>
													<a href="#"><img src="images/del.png" id="icon" title="delete" /> </a> 
												</td>
												<td colspan="4" id="num">
													 
													';
												if($brand[$i] != NULL)
												{
													echo '
													

														<a href="#">'.$item[$i].', '.$desc[$i].' ('.$brand[$i].') </a>	
													';
												}	
												else 
												{
													echo '
														<a href="#">'.$item[$i].', '.$desc[$i].'  </a>	
													';
												}
													
													
												echo '
												</td>
												<td colspan="1" id="num2">
													'.$bal[$i].' 
												</td>
												<td id="num2">											
													'.$unit[$i].'
												</td>
											</tr>';
								   		
								   	}	
						echo'	</table>	
						</div>';
?>