
<?php 
session_start();
if (!isset($_SESSION['username']))
	{
	//print "<script>alert('You Failed to Log In')</script>";
	header ("location: logform.php");
	} 
	
include 'database/dbconnect.php';

		
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


			//if search text field is empty, show all records from purchase_order table
			if((!isset($_GET['searchtxt'])) || (!isset($_GET['searchby'])) || $_GET['searchby'] == "" )
			{
					$qrypo = "SELECT * FROM purchase_order order by created desc";
					$mysql = $conn->query($qrypo);
					$ctr=1;
					if ($mysql->num_rows > 0)	
					{
						while($row = $mysql->fetch_assoc())	
						{
							$poid = $row['id'];
							$po_no = $row['po_number'];
							$category = $row['category'];
							$podate = $row['podate'];
							$suppid = $row['supplierid'];
							$status = $row['status'];
							$confdate = $row['confdate'];
							$dterm = $row['dterm'];


							//compute if the PO is beyond or within
							$date1 = strtotime($confdate);
							$date2 = strtotime($currentdate);
							$interval = $date2 - $date1;
							$interval = floor($interval/86400);
							
							if ($interval <= $dterm)
							{
								$wb = "<a href='rcv.php?poid=".$poid."' target='_parent' style='color: green;'>Within </a>";
							}
							else
							{
								$wb = "<a href='rcv.php?poid=".$poid."' target='_parent' style='color: red;'>Beyond </a>";
							}
							
							//get supplier's name of the po
							$qrysupp = "SELECT * FROM itrmc_db01.supplier WHERE id = $suppid";
							$mysqla = $conn->query($qrysupp);
							if ($mysqla->num_rows > 0)
								{
									while($rowi = $mysqla->fetch_assoc())
									{
										$suppname= $rowi['name'];
									}	
								}

							//get the first line item 
							//get it first from po_poitems
							$qrypoitem = "SELECT * from itrmc_db01.po_poitems where po_id = $poid order by poitem_id asc limit 1";
							$mysqlb = $conn->query($qrypoitem);
							if ($mysqlb->num_rows > 0)
								{
									while($rowb = $mysqlb->fetch_assoc())
									{
										$poitemid= $rowb['poitem_id'];
									}	
								}
							//then get the item desc from the po_item tbl
							$qrypoitem01 = "SELECT * from itrmc_db01.po_item where id = $poitemid";
							$mysqlpoitem01 = $conn->query($qrypoitem01);
							if ($mysqlpoitem01->num_rows > 0)
								{
									while($rowpoitem01 = $mysqlpoitem01->fetch_assoc())
									{
										$itemdesc= $rowpoitem01['itemdesc'];
									}
								}
							//get the first 90 chars of the item desc
							$itemdesc01 = substr($itemdesc,0, 90);

							//get requestedby and the dept
							//first get the pr id from the porispr tbl
							$qrypr01 = "SELECT * from itrmc_db01.porispr where po_no = $po_no";
							$mysqlpr01 = $conn->query($qrypr01);
							if ($mysqlpr01->num_rows > 0)
								{
									while($rowpr01 = $mysqlpr01->fetch_assoc())
									{
										$prid = $rowpr01['pr_id'];
									}
								}
							//then get the reqby and dept from pr tbl
							$qrypr02 = "SELECT * from itrmc_db01.pr where id = $prid";
							$mysqlpr02 = $conn->query($qrypr02);
							if ($mysqlpr02->num_rows > 0)
								{
									while($rowpr02 = $mysqlpr02->fetch_assoc())
									{
										$reqby = $rowpr02['reqby'];
										$dept = $rowpr02['deptbranch'];
										$sect = $rowpr02['section'];
									}
								}
							else
								{
									$reqby = "";
									$dept = "";
								}

							echo '<tr>
									<td>
										'.$ctr.'		
									</td>
									<td>
										'.$po_no.'		
									</td>
									<td>
										'.$suppname.'		
									</td>
									<td>
										'.$category.'		
									</td>
									<td colspan="3">
										'.$itemdesc01.'...		
									</td>
									<td colspan="2">
										'.$reqby.' / '.$dept.'	- '.$sect.'	
									</td>
									
									<td>
										'.$podate.'		
									</td>
									<td colspan="2">
										'.$status.'		
									</td>
									
									<td colspan="2">
										<a href="poview.php?djm='.$poid.'" target="_top">View</a> | <a href="poedit.php?djm='.$poid.'" target="_top">Edit</a> | <a href="podelete.php?djm='.$poid.'" target="_top">Delete</a>
									</td>
									<td colspan="1">
										'.$wb.'		
									</td>
							   </tr>';	

								

							//increment ctr for the loop :)
							$ctr++;
						}	
					}
					else
					{
						echo "<table id='record'>

						<tr><td> No record yet. </td></tr>
						<tr><td> <a href='po.php' target='_top'>Add New Record</a> </td></tr>
						</table>
						";		
					}	
			}


			//if search text field is NOT empty, show all records from purchase_order table in accordance to search criteria
			elseif ((isset($_GET['searchtxt'])) AND (isset($_GET['searchby'])) )
			{
				$search = $_GET['searchtxt'];
				$by = $_GET['searchby'];

				switch ($by) 
				{
					case 'created':
					case 'po_number':
					case 'category':
					case 'podate':
					case 'status':
									$qrypo01 = "SELECT * FROM itrmc_db01.purchase_order where $by like '%$search%' order by $by desc";
									$mysql01 = $conn->query($qrypo01);
									$ctr=1;
									if ($mysql01->num_rows > 0)	
									/*if ($result = $conn->query($qrypo01))*/
									{
										while($row = $mysql01->fetch_assoc())	
										/*while($row = $result->fetch_assoc())*/
										{
											$poid = $row['id'];
											$po_no = $row['po_number'];
											$category = $row['category'];
											$podate = $row['podate'];
											$suppid = $row['supplierid'];
											$status = $row['status'];
											$confdate = $row['confdate'];
											$dterm = $row['dterm'];
											
											//compute if the PO is beyond or within
											$date1 = strtotime($confdate);
											$date2 = strtotime($currentdate);
											$interval = $date2 - $date1;
											$interval = floor($interval/86400);
											
											if ($interval <= $dterm)
											{
												$wb = "<a href='rcv.php?poid=".$poid."' target='_parent' style='color: green;'>Within </a>";
											}
											else
											{
												$wb = "<a href='rcv.php?poid=".$poid."' target='_parent' style='color: red;'>Beyond </a>";
											}

											//get supplier's name of the po
											$qrysupp = "SELECT * FROM itrmc_db01.supplier WHERE id = $suppid";
											$mysqla = $conn->query($qrysupp);
											if ($mysqla->num_rows > 0)
												{
													while($rowi = $mysqla->fetch_assoc())
													{
														$suppname= $rowi['name'];
													}	
												}

											//get the first line item 
											//get it first from po_poitems
											$qrypoitem = "SELECT * from itrmc_db01.po_poitems where po_id = $poid order by poitem_id asc limit 1";
											$mysqlb = $conn->query($qrypoitem);
											if ($mysqlb->num_rows > 0)
												{
													while($rowb = $mysqlb->fetch_assoc())
													{
														$poitemid= $rowb['poitem_id'];
													}	
												}
											//then get the item desc from the po_item tbl
											$qrypoitem01 = "SELECT * from itrmc_db01.po_item where id = $poitemid";
											$mysqlpoitem01 = $conn->query($qrypoitem01);
											if ($mysqlpoitem01->num_rows > 0)
												{
													while($rowpoitem01 = $mysqlpoitem01->fetch_assoc())
													{
														$itemdesc= $rowpoitem01['itemdesc'];
													}
												}
											//get the first 90 chars of the item desc
											$itemdesc01 = substr($itemdesc,0, 90);

											//get requestedby and the dept
											//first get the pr id from the porispr tbl
											$qrypr01 = "SELECT * from itrmc_db01.porispr where po_no = $po_no";
											$mysqlpr01 = $conn->query($qrypr01);
											if ($mysqlpr01->num_rows > 0)
												{
													while($rowpr01 = $mysqlpr01->fetch_assoc())
													{
														$prid = $rowpr01['pr_id'];
													}
												}
											//then get the reqby and dept from pr tbl
											$qrypr02 = "SELECT * from itrmc_db01.pr where id = $prid";
											$mysqlpr02 = $conn->query($qrypr02);
											if ($mysqlpr02->num_rows > 0)
												{
													while($rowpr02 = $mysqlpr02->fetch_assoc())
													{
														$reqby = $rowpr02['reqby'];
														$dept = $rowpr02['deptbranch'];
														$sect = $rowpr02['section'];
													}
												}
											else
												{
													$reqby = "";
													$dept = "";
												}
											echo '<tr>
													<td>
														'.$ctr.'		
													</td>
													<td>
														'.$po_no.'		
													</td>
													<td>
														'.$suppname.'		
													</td>
													<td>
														'.$category.'		
													</td>
													<td colspan="3">
														'.$itemdesc01.'...		
													</td>
													<td colspan="2">
														'.$reqby.' / '.$dept.' - '.$sect.'		
													</td>
													
													<td>
														'.$podate.'		
													</td>
													<td colspan="2">
														'.$status.'		
													</td>
													<td colspan="2">
														<a href="poview.php?djm='.$poid.'" target="_top">View</a> | <a href="poedit.php?djm='.$poid.'" target="_top">Edit</a> | <a href="podelete.php?djm='.$poid.'" target="_top">Delete</a>
													</td>
													<td colspan="1">
														
														'.$wb.'		
													</td>
											   </tr>';		
											$ctr++;
										}	
									}
									else
									{
										echo "<table id='record'>
										<tr><td> No match found.</td></tr>
										</table>
										";		
									}

						break;

					case 'name': //search by supplier
									$qry02 = "SELECT * from supplier inner JOIN purchase_order on purchase_order.supplierid = supplier.id WHERE $by like '%$search%' order by $by asc";
									$mysql02 = $conn->query($qry02);
									$ctr=1;
									if ($mysql02->num_rows > 0)	
									{
										while($row02 = $mysql02->fetch_assoc())
										{
											$poid = $row02['id']; 
											$po_no = $row02['po_number'];
											$category = $row02['category'];
											$podate = $row02['podate'];
											$suppid = $row02['supplierid'];
											$status = $row02['status'];
											$suppname = $row02['name'];
											$confdate = $row02['confdate'];
											$dterm = $row02['dterm'];
											

											//compute if the PO is beyond or within
											$date1 = strtotime($confdate);
											$date2 = strtotime($currentdate);
											$interval = $date2 - $date1;
											$interval = floor($interval/86400);
											
											if ($interval <= $dterm)
											{
												$wb = "<a href='rcv.php?poid=".$poid."' target='_parent' style='color: green;'>Within </a>";
											}
											else
											{
												$wb = "<a href='rcv.php?poid=".$poid."' target='_parent' style='color: red;'>Beyond </a>";
											}

											

											//get the first line item, get the id first
											$qrypoitem = "SELECT * from itrmc_db01.po_poitems where po_id = $poid order by poitem_id asc limit 1";
											$mysqlb = $conn->query($qrypoitem);
											if ($mysqlb->num_rows > 0)
												{
													while($rowb = $mysqlb->fetch_assoc())
													{
														$poitemid= $rowb['poitem_id'];
													}	
												}
											
											//then get the item desc from the po_item tbl
											$qrypoitem01 = "SELECT * from itrmc_db01.po_item where id = $poitemid";
											$mysqlpoitem01 = $conn->query($qrypoitem01);
											if ($mysqlpoitem01->num_rows > 0)
												{
													while($rowpoitem01 = $mysqlpoitem01->fetch_assoc())
													{
														$itemdesc= $rowpoitem01['itemdesc'];
													}
												}
											//get the first 90 chars of the item desc
											$itemdesc01 = substr($itemdesc,0, 90);

											//get requestedby and the dept
											//first get the pr id from the porispr tbl
											$qrypr01 = "SELECT * from itrmc_db01.porispr where po_no = $po_no";
											$mysqlpr01 = $conn->query($qrypr01);
											if ($mysqlpr01->num_rows > 0)
												{
													while($rowpr01 = $mysqlpr01->fetch_assoc())
													{
														$prid = $rowpr01['pr_id'];
													}
												}

											//then get the reqby and dept from pr tbl
											$qrypr02 = "SELECT * from itrmc_db01.pr where id = $prid";
											$mysqlpr02 = $conn->query($qrypr02);
											if ($mysqlpr02->num_rows > 0)
												{
													while($rowpr02 = $mysqlpr02->fetch_assoc())
													{
														$reqby = $rowpr02['reqby'];
														$dept = $rowpr02['deptbranch'];
														$sect = $rowpr02['section'];
													}
												}
											else
												{
													$reqby = "";
													$dept = "";
												}

											//print the search results
											echo '<tr>
													<td>
														'.$ctr.'		
													</td>
													<td>
														'.$po_no.'		
													</td>
													<td>
														'.$suppname.'		
													</td>
													<td>
														'.$category.'		
													</td>
													<td colspan="3">
														'.$itemdesc01.'...		
													</td>
													<td colspan="2">
														'.$reqby.' / '.$dept.' - '.$sect.'		
													</td>
													
													<td>
														'.$podate.'		
													</td>
													<td colspan="2">
														'.$status.'		
													</td>
													<td colspan="2">
														<a href="poview.php?djm='.$poid.'" target="_top">View</a> | <a href="poedit.php?djm='.$poid.'" target="_top">Edit</a> | <a href="podelete.php?djm='.$poid.'" target="_top">Delete</a>
													</td>
													<td colspan="1">
														
														'.$wb.'		
													</td>
											   </tr>';		
											$ctr++;

										}
									}
									else
									{
										echo "<table id='record'>
										<tr><td> No match found.</td></tr>
										</table>
										";
									}
						break;

					case 'itemdesc':
									$qry03 ="SELECT * FROM  itrmc_db01.po_item
											left join itrmc_db01.po_poitems on po_item.id = po_poitems.poitem_id
											left join itrmc_db01.purchase_order on po_poitems.po_id = purchase_order.id
											where po_item.itemdesc like '%$search%' order by po_poitems.poitem_id asc ";
									$mysql03 = $conn->query($qry03);
									$ctr=1;
									if ($mysql03 -> num_rows >0)
									{
										while($row03 = $mysql03->fetch_assoc())
										{
											$po_no = $row03['po_number'];
											$poid = $row03['id'];
											$category = $row03['category'];
											$podate = $row03['podate'];
											$suppid = $row03['supplierid'];
											$status = $row03['status'];
											$itemdesc = $row03['itemdesc'];
											$itemdesc01 = substr($itemdesc,0, 90);
											$confdate = $row03['confdate'];
											$dterm = $row03['dterm'];
											

											//compute if the PO is beyond or within
											$date1 = strtotime($confdate);
											$date2 = strtotime($currentdate);
											$interval = $date2 - $date1;
											$interval = floor($interval/86400);
											
											if ($interval <= $dterm)
											{
												$wb = "<a href='rcv.php?poid=".$poid."' target='_parent' style='color: green;'>Within </a>";
											}
											else
											{
												$wb = "<a href='rcv.php?poid=".$poid."' target='_parent' style='color: red;'>Beyond </a>";
											}


											//get supplier
											//get supplier's name of the po
											$qrysupp = "SELECT * FROM itrmc_db01.supplier WHERE id = $suppid";
											$mysqla = $conn->query($qrysupp);
											if ($mysqla->num_rows > 0)
												{
													while($rowi = $mysqla->fetch_assoc())
													{
														$suppname= $rowi['name'];
													}	
												}

											//get requested by
											$qrypr01 = "SELECT * FROM itrmc_db01.purchase_order
												left join itrmc_db01.porispr on purchase_order.po_number = porispr.po_no
												left join itrmc_db01.pr on porispr.pr_id = pr.id
												where porispr.po_no = $po_no ";
											$mysqlpr01 = $conn->query($qrypr01);
											if ($mysqlpr01->num_rows > 0)
												{
													while($rowpr01 = $mysqlpr01->fetch_assoc())
													{
														$reqby = $rowpr01['reqby'];
														$dept = $rowpr01['deptbranch'];
														$sect = $rowpr01['section'];
													}
												}
											else
												{
													$reqby = "";
													$dept = "";
												}

											echo '<tr>
													<td>
														'.$ctr.'		
													</td>
													<td>
														'.$po_no.'		
													</td>
													<td>
														'.$suppname.'		
													</td>
													<td>
														'.$category.'		
													</td>
													<td colspan="3">
														'.$itemdesc01.'...		
													</td>
													<td colspan="2">
														'.$reqby.' / '.$dept.' - '.$sect.'	
													</td>
													
													<td>
														'.$podate.'		
													</td>
													<td colspan="2">
														'.$status.'		
													</td>
													<td colspan="2">
														<a href="poview.php?djm='.$poid.'" target="_top">View</a> | <a href="poedit.php?djm='.$poid.'" target="_top">Edit</a> | <a href="podelete.php?djm='.$poid.'" target="_top">Delete</a>
													</td>
													<td colspan="1">
														'.$wb.'		
													</td>
											   </tr>';		
											$ctr++;

										}

									}
									else
									{
										echo "<table id='record'>
										<tr><td> No match found.</td></tr>
										</table>
										";
									}
						break;
									
					case 'deptbranch':
									$qry04 = "SELECT * FROM itrmc_db01.pr
											left join itrmc_db01.porispr on porispr.pr_id = pr.id
											left join itrmc_db01.purchase_order on  purchase_order.po_number = porispr.po_no
											where pr.deptbranch like '%$search%' or  pr.section like '%$search%' order by pr.deptbranch asc";
									$mysql04 = $conn->query($qry04);
									$ctr=1;
									if ($mysql04->num_rows > 0)	
									{
										while($row04 = $mysql04->fetch_assoc())
										{
											$poid = $row04['id'];
											$po_no = $row04['po_number'];
											$category = $row04['category'];
											$podate = $row04['podate'];
											$suppid = $row04['supplierid'];
											$status = $row04['status'];
											$reqby = $row04['reqby'];
											$dept = $row04['deptbranch'];
											$sect = $row04['section'];
											$confdate = $row04['confdate'];
											$dterm = $row04['dterm'];
											

											//compute if the PO is beyond or within
											$date1 = strtotime($confdate);
											$date2 = strtotime($currentdate);
											$interval = $date2 - $date1;
											$interval = floor($interval/86400);
											
											if ($interval <= $dterm)
											{
												$wb = "<a href='rcv.php?poid=".$poid."' target='_parent' style='color: green;'>Within </a>";
											}
											else
											{
												$wb = "<a href='rcv.php?poid=".$poid."' target='_parent' style='color: red;'>Beyond </a>";
											}

											
											//get supplier's name of the po
											$qrysupp = "SELECT * FROM itrmc_db01.supplier WHERE id = $suppid";
											$mysqla = $conn->query($qrysupp);
											if ($mysqla->num_rows > 0)
												{
													while($rowi = $mysqla->fetch_assoc())
													{
														$suppname= $rowi['name'];
													}	
												}

											//get the first line item 
											//get it first from po_poitems
											$qrypoitem = "SELECT * from itrmc_db01.po_poitems where po_id = $poid order by poitem_id asc limit 1";
											$mysqlb = $conn->query($qrypoitem);
											if ($mysqlb->num_rows > 0)
												{
													while($rowb = $mysqlb->fetch_assoc())
													{
														$poitemid= $rowb['poitem_id'];
													}	
												}
											//then get the item desc from the po_item tbl
											$qrypoitem01 = "SELECT * from itrmc_db01.po_item where id = $poitemid";
											$mysqlpoitem01 = $conn->query($qrypoitem01);
											if ($mysqlpoitem01->num_rows > 0)
												{
													while($rowpoitem01 = $mysqlpoitem01->fetch_assoc())
													{
														$itemdesc= $rowpoitem01['itemdesc'];
													}
												}
											//get the first 90 chars of the item desc
											$itemdesc01 = substr($itemdesc,0, 90);

											echo '<tr>
													<td>
														'.$ctr.'		
													</td>
													<td>
														'.$po_no.'		
													</td>
													<td>
														'.$suppname.'		
													</td>
													<td>
														'.$category.'		
													</td>
													<td colspan="3">
														'.$itemdesc01.'...		
													</td>
													<td colspan="2">
														'.$reqby.' / '.$dept.'-'.$sect.'		
													</td>
													
													<td>
														'.$podate.'		
													</td>
													<td colspan="2">
														'.$status.'		
													</td>
													<td colspan="2">
														<a href="poview.php?djm='.$poid.'" target="_top">View</a> | <a href="poedit.php?djm='.$poid.'" target="_top">Edit</a> | <a href="podelete.php?djm='.$poid.'" target="_top">Delete</a>
													</td>
													<td colspan="1">
														'.$wb.'		
													</td>
											   </tr>';		
											$ctr++;

										}
									}
									else
									{
										echo "<table id='record'>
										<tr><td> No match found.</td></tr>
										</table>
										";
									}
					
					break;
					case 'Within':
									$qrywithin = "SELECT * from supplier 
													inner JOIN purchase_order on purchase_order.supplierid = supplier.id 
													WHERE purchase_order.po_number like '%$search%' 
													OR supplier.name like '%$search%' order by purchase_order.po_number desc";
									$mysqlwithin = $conn->query($qrywithin);
									$ctr= 0;
									if ($mysqlwithin->num_rows > 0)
									{
										while ($row05 = $mysqlwithin-> fetch_assoc())
										{
											
											$poid = $row05['id'];
											$po_no = $row05['po_number'];
											$category = $row05['category'];
											$podate = $row05['podate'];
											$suppid = $row05['supplierid'];
											$status = $row05['status'];
											
											$confdate = $row05['confdate'];
											$dterm = $row05['dterm'];
											$suppname= $row05['name'];

											//get the first line item 
											//get it first from po_poitems
											$qrypoitem = "SELECT * from itrmc_db01.po_poitems where po_id = $poid order by poitem_id asc limit 1";
											$mysqlb = $conn->query($qrypoitem);
											if ($mysqlb->num_rows > 0)
												{
													while($rowb = $mysqlb->fetch_assoc())
													{
														$poitemid= $rowb['poitem_id'];
													}	
												}
											//then get the item desc from the po_item tbl
											$qrypoitem01 = "SELECT * from itrmc_db01.po_item where id = $poitemid";
											$mysqlpoitem01 = $conn->query($qrypoitem01);
											if ($mysqlpoitem01->num_rows > 0)
												{
													while($rowpoitem01 = $mysqlpoitem01->fetch_assoc())
													{
														$itemdesc= $rowpoitem01['itemdesc'];
													}
												}
											//get the first 90 chars of the item desc
											$itemdesc01 = substr($itemdesc,0, 90);

											//get requestedby and the dept
											//first get the pr id from the porispr tbl
											$qrypr01 = "SELECT * from itrmc_db01.porispr where po_no = $po_no";
											$mysqlpr01 = $conn->query($qrypr01);
											if ($mysqlpr01->num_rows > 0)
												{
													while($rowpr01 = $mysqlpr01->fetch_assoc())
													{
														$prid = $rowpr01['pr_id'];
													}
												}
											//then get the reqby and dept from pr tbl
											$qrypr02 = "SELECT * from itrmc_db01.pr where id = $prid";
											$mysqlpr02 = $conn->query($qrypr02);
											if ($mysqlpr02->num_rows > 0)
												{
													while($rowpr02 = $mysqlpr02->fetch_assoc())
													{
														$reqby = $rowpr02['reqby'];
														$dept = $rowpr02['deptbranch'];
														$sect = $rowpr02['section'];
													}
												}
											else
												{
													$reqby = "";
													$dept = "";
												}



											//compute if the PO is within then print
											$date1 = strtotime($confdate);
											$date2 = strtotime($currentdate);
											$interval = $date2 - $date1;
											$interval = floor($interval/86400);
											
											if ($interval <= $dterm)
											{
												$ctr++;
												$wb = "<a href='rcv.php?poid=".$poid."' target='_parent' style='color: green;'>Within </a>";
												echo '<tr>
													<td>
														'.$ctr.'		
													</td>
													<td>
														'.$po_no.'		
													</td>
													<td>
														'.$suppname.'		
													</td>
													<td>
														'.$category.'		
													</td>
													<td colspan="3">
														'.$itemdesc01.'...		
													</td>
													<td colspan="2">
														'.$reqby.' / '.$dept.'	- '.$sect.'	
													</td>
													
													<td>
														'.$podate.'		
													</td>
													<td colspan="2">
														'.$status.'		
													</td>
													
													<td colspan="2">
														<a href="poview.php?djm='.$poid.'" target="_top">View</a> | <a href="poedit.php?djm='.$poid.'" target="_top">Edit</a> | <a href="podelete.php?djm='.$poid.'" target="_top">Delete</a>
													</td>
													<td colspan="1">
														'.$wb.'		
													</td>
											   </tr>';
											   //increment ctr for the item's counter :)
												
											}
											

										}
									}
									if($ctr == 0)
									{
										echo "<table id='record'>
										<tr><td> No match found.</td></tr>
										</table>
										";
									}
						break;

					case 'Beyond':
									$qrywithin = "SELECT * from supplier 
													inner JOIN purchase_order on purchase_order.supplierid = supplier.id 
													WHERE purchase_order.po_number like '%$search%' 
													OR supplier.name like '%$search%' order by purchase_order.po_number desc";
									$mysqlwithin = $conn->query($qrywithin);
									$ctr= 0;
									if ($mysqlwithin->num_rows > 0)
									{
										while ($row05 = $mysqlwithin-> fetch_assoc())
										{
											
											$poid = $row05['id'];
											$po_no = $row05['po_number'];
											$category = $row05['category'];
											$podate = $row05['podate'];
											$suppid = $row05['supplierid'];
											$status = $row05['status'];
											
											$confdate = $row05['confdate'];
											$dterm = $row05['dterm'];
											$suppname= $row05['name'];

											//get the first line item 
											//get it first from po_poitems
											$qrypoitem = "SELECT * from itrmc_db01.po_poitems where po_id = $poid order by poitem_id asc limit 1";
											$mysqlb = $conn->query($qrypoitem);
											if ($mysqlb->num_rows > 0)
												{
													while($rowb = $mysqlb->fetch_assoc())
													{
														$poitemid= $rowb['poitem_id'];
													}	
												}
											//then get the item desc from the po_item tbl
											$qrypoitem01 = "SELECT * from itrmc_db01.po_item where id = $poitemid";
											$mysqlpoitem01 = $conn->query($qrypoitem01);
											if ($mysqlpoitem01->num_rows > 0)
												{
													while($rowpoitem01 = $mysqlpoitem01->fetch_assoc())
													{
														$itemdesc= $rowpoitem01['itemdesc'];
													}
												}
											//get the first 90 chars of the item desc
											$itemdesc01 = substr($itemdesc,0, 90);

											//get requestedby and the dept
											//first get the pr id from the porispr tbl
											$qrypr01 = "SELECT * from itrmc_db01.porispr where po_no = $po_no";
											$mysqlpr01 = $conn->query($qrypr01);
											if ($mysqlpr01->num_rows > 0)
												{
													while($rowpr01 = $mysqlpr01->fetch_assoc())
													{
														$prid = $rowpr01['pr_id'];
													}
												}
											//then get the reqby and dept from pr tbl
											$qrypr02 = "SELECT * from itrmc_db01.pr where id = $prid";
											$mysqlpr02 = $conn->query($qrypr02);
											if ($mysqlpr02->num_rows > 0)
												{
													while($rowpr02 = $mysqlpr02->fetch_assoc())
													{
														$reqby = $rowpr02['reqby'];
														$dept = $rowpr02['deptbranch'];
														$sect = $rowpr02['section'];
													}
												}
											else
												{
													$reqby = "";
													$dept = "";
												}

											$date1 = strtotime($confdate);
											$date2 = strtotime($currentdate);
											$interval = $date2 - $date1;
											$interval = floor($interval/86400);
											
											if ($interval > $dterm)
											{
												$ctr++;
												$wb = "<a href='rcv.php?poid=".$poid."' target='_parent' style='color: red;'>Beyond  </a>";
												echo '<tr>
													<td>
														'.$ctr.'		
													</td>
													<td>
														'.$po_no.'		
													</td>
													<td>
														'.$suppname.'		
													</td>
													<td>
														'.$category.'		
													</td>
													<td colspan="3">
														'.$itemdesc01.'...		
													</td>
													<td colspan="2">
														'.$reqby.' / '.$dept.'	- '.$sect.'	
													</td>
													
													<td>
														'.$podate.'		
													</td>
													<td colspan="2">
														'.$status.'		
													</td>
													
													<td colspan="2">
														<a href="poview.php?djm='.$poid.'" target="_top">View</a> | <a href="poedit.php?djm='.$poid.'" target="_top">Edit</a> | <a href="podelete.php?djm='.$poid.'" target="_top">Delete</a>
													</td>
													<td colspan="1">
														'.$wb.'		
													</td>
											   </tr>';
											   
												
											}

										}
									}
									if($ctr < 1)
									{
										echo "<table id='record'>
										<tr><td> No match found.</td></tr>
										</table>
										";
									}
						break;

				}
				
			}

			?>
			</table>
		</div>
	</body>
</html>