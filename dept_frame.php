
<?php 
session_start();
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';

$aname = "";			
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		
	</head>
	<body>
		<div id="">
			<table id="record">
				
			<?php 
			
			 $currentdate = date('Y-m-d');
			 $ctr = 1;

			//if search text field is empty, show all records from purchase_order table
			if((!isset($_GET['searchtxt'])) or ($_GET['searchtxt'] == ""))
			{
					$qrypo = "SELECT * FROM dept order by name asc";
					$mysql = $conn->query($qrypo);
					$ctr=1;
					if ($mysql->num_rows > 0)	
					{
						while($row = $mysql->fetch_assoc())	
						{
							$id = $row['id'];
							$name = ucwords(strtolower($row['name'])) ;
							$desc = ucwords($row['description']);
							$stat = $row['stat'];
							if ($stat == "1") 
							{
								$stat = "Active";
							}
							else
							{
								$stat = "Inactive";
							}

							//insert inner join here for the head of the dept

							echo '
							<tr>
								<td>
									'.$ctr++.'.		
								</td>
								<td colspan="3">
									'.$name.'		
								</td>
								<td colspan="2">
									'.$desc.'		
								</td>
								<td colspan="2">
									Head of Department	
								</td>
								<td>
									'.$stat.'	
								</td>
							</tr>
								';

						}
						

					}
					elseif (isset($_GET['searchtxt']))
					{
						echo "<table id='record'>

						<tr><td> No record yet. </td></tr>
						<tr><td colspan='2'> <a href='adddept.php' target='_top'>Add a new Section</a> </td></tr>
						</table>
						";		
					}	
			}


			//if search text field is NOT empty, show all records from purchase_order table in accordance to search criteria
			elseif (isset($_GET['searchtxt']))
			{
				$search = $_GET['searchtxt'];
				$qrypo = "SELECT * FROM dept where name Like '%$search%' order by name asc";
				$mysql = $conn->query($qrypo);
				$ctr=1;
				if ($mysql->num_rows > 0)	
				{
					while($row = $mysql->fetch_assoc())	
					{
						$id = $row['id'];
							$name = ucwords(strtolower($row['name'])) ;
							$desc = ucwords($row['description']);
							$stat = $row['stat'];
							if ($stat == "1") 
							{
								$stat = "Active";
							}
							else
							{
								$stat = "Inactive";
							}

							//insert inner join here for the head of the dept


						echo '
							<tr>
								<td>
									'.$ctr++.'.		
								</td>
								<td colspan="3">
									'.$name.'		
								</td>
								<td colspan="2">
									'.$desc.'		
								</td>
								<td colspan="2">
									Head of Department	
								</td>
								<td>
									'.$stat.'	
								</td>
							</tr>
								';
					}
					
				}
				else
				{
					echo "<table id='record'>

					<tr><td> No record yet. </td></tr>
					
					</table>
					";		
				}
			
			}

			?>
			</table>
		</div>
	</body>
</html>