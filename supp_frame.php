
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
					$qrypo = "SELECT * FROM supplier where supp_status = '1' order by name asc";
					$mysql = $conn->query($qrypo);
					$ctr=1;
					if ($mysql->num_rows > 0)	
					{
						while($row = $mysql->fetch_assoc())	
						{
							$id = $row['id'];
							$name = ucwords(strtolower($row['name'])) ;
							$add = ucwords(strtolower($row['address']));
							$agent = $row['agent_id'];

							$tel = $row['telcontact'];
							$cp = $row['cpcontact'];
							$email = $row['email'];

							$qrypoc = "SELECT * from contact 
										inner join agentprof on contact.id =agentprof.contactid
										inner join profile on agentprof.profileid = profile.id
										where agentprof.companyid = $id";
							$mysqlpoc = $conn->query($qrypoc);
							if ($mysqlpoc->num_rows > 0) 
							{
								while ($row2 = $mysqlpoc->fetch_assoc()) 
								{
									/*$fname = $row2['fname'];
									$lname = $row2['lname'];
									$fname = ucwords(strtolower($fname));
									$lname = ucwords(strtolower($lname));*/
									$aname = $row2['fname'].' '.$row2['lname'];
									$aname = ucwords(strtolower($aname));
								}
							}

							echo '
							<tr>
								<td>
									'.$ctr++.'.		
								</td>
								<td colspan="3">
									'.$name.'		
								</td>
								<td colspan="2">
									'.$add.'		
								</td>
								<td>
									'.$tel.' <br> '.$cp.'		
								</td>
								<td colspan="2">
									'.$aname.' <br> '.$email.'	
								</td>
							</tr>
								';

						}
						

					}
					elseif (isset($_GET['searchtxt']))
					{
						echo "<table id='record'>

						<tr><td> No record yet. </td></tr>
						<tr><th colspan='2'> <a href='addsupp.php' target='_top'>Add a new Supplier</a> </th></tr>
						</table>
						";		
					}	
			}


			//if search text field is NOT empty, show all records from purchase_order table in accordance to search criteria
			elseif (isset($_GET['searchtxt']))
			{
				$search = $_GET['searchtxt'];
				$qrypo = "SELECT * FROM supplier where supp_status = '1' and name Like '%$search%' order by name asc";
				$mysql = $conn->query($qrypo);
				$ctr=1;
				if ($mysql->num_rows > 0)	
				{
					while($row = $mysql->fetch_assoc())	
					{
						$id = $row['id'];
						$name = ucwords(strtolower($row['name'])) ;
						$add = ucwords(strtolower($row['address']));
						$agent = $row['agent_id'];

						$tel = $row['telcontact'];
						$cp = $row['cpcontact'];
						$email = $row['email'];
						$qrypoc = "SELECT * from contact 
										inner join agentprof on contact.id =agentprof.contactid
										inner join profile on agentprof.profileid = profile.id
										where agentprof.companyid = $id";
							$mysqlpoc = $conn->query($qrypoc);
						if ($mysqlpoc->num_rows > 0) 
						{
							while ($row2 = $mysqlpoc->fetch_assoc()) 
							{
								/*$fname = $row2['fname'];
								$lname = $row2['lname'];
								$fname = ucwords(strtolower($fname));
								$lname = ucwords(strtolower($lname));*/
								$aname = $row2['fname'].' '.$row2['lname'];
								$aname = ucwords(strtolower($aname));
							}
						}

						echo '
						<tr>
							<td>
								'.$ctr++.'.		
							</td>
							<td colspan="3">
								'.$name.'		
							</td>
							<td colspan="2">
								'.$add.'		
							</td>
							<td>
								'.$tel.' <br> '.$cp.'		
							</td>
							<td >
								'.$aname.' <br> '.$email.'	
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