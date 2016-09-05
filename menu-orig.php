<?php
$currentpage = $_SESSION['currentpage'];

if ($currentpage == "dashboard")
{
	echo "
	<ul>
		<li><a href='index.php' id='current'> Dashboard </a></li>
		<li><a href='po.php'> PO</a></li>

		<li><a href='#'>Receiving</a></li>
		<li><a href='#'> Disb Voucher</a></li>
		<li><a href='#'> Issuance</a></li>
		<li><a href='#'> Disposal</a></li>
		<li><a href='#'>Supplier</a></li>
		<li><a href='#'> Reports</a></li>
	</ul> ";
}
else if ($currentpage == "PO")
{
	echo "
	<ul>
		<li><a href='index.php'> Dashboard </a></li>
		<li><a href='po.php' id='current'> PO</a></li>
		<li><a href='#'>Receiving</a></li>
		<li><a href='#'> Disb Voucher</a></li>
		<li><a href='#'> Issuance</a></li>
		<li><a href='#'> Disposal</a></li>
		<li><a href='#'>Supplier</a></li>
		<li><a href='#'> Reports</a></li>
	</ul> ";
}
else if ($currentpage == "receiving")
{
	echo "
	<ul>
		<li><a href='index.php'> Dashboard </a></li>
		<li><a href='po.php'> PO</a></li>
		<li><a href='#' id='current'>Receiving</a></li>
		<li><a href='#'> Disb Voucher</a></li>
		<li><a href='#'> Issuance</a></li>
		<li><a href='#'> Disposal</a></li>
		<li><a href='#'>Supplier</a></li>
		<li><a href='#'> Reports</a></li>
	</ul> ";
}
else if ($currentpage == "DV")
{
	echo "
	<ul>
		<li><a href='index.php'> Dashboard </a></li>
		<li><a href='po.php'> PO</a></li>
		<li><a href='#'>Receiving</a></li>
		<li><a href='#' id='current'> Disb Voucher</a></li>
		<li><a href='#'> Issuance</a></li>
		<li><a href='#'> Disposal</a></li>
		<li><a href='#'>Supplier</a></li>
		<li><a href='#'> Reports</a></li>
	</ul> ";
}
else if ($currentpage == "issuance")
{
	echo "
	<ul>
		<li><a href='index.php'> Dashboard </a></li>
		<li><a href='po.php'> PO</a></li>
		<li><a href='#'>Receiving</a></li>
		<li><a href='#'> Disb Voucher</a></li>
		<li><a href='#' id='current'> Issuance</a></li>
		<li><a href='#'> Disposal</a></li>
		<li><a href='#'>Supplier</a></li>
		<li><a href='#'> Reports</a></li>
	</ul> ";
}
else if ($currentpage == "disposal")
{
	echo "
	<ul>
		<li><a href='index.php'> Dashboard </a></li>
		<li><a href='po.php'> PO</a></li>
		<li><a href='#'>Receiving</a></li>
		<li><a href='#'> Disb Voucher</a></li>
		<li><a href='#'> Issuance</a></li>
		<li><a href='#' id='current'> Disposal</a></li>
		<li><a href='#'>Supplier</a></li>
		<li><a href='#'> Reports</a></li>
	</ul> ";
}
else if ($currentpage == "supplier")
{
	echo "
	<ul>
		<li><a href='index.php'> Dashboard </a></li>
		<li><a href='po.php'> PO</a></li>
		<li><a href='#'>Receiving</a></li>
		<li><a href='#'> Disb Voucher</a></li>
		<li><a href='#'> Issuance</a></li>
		<li><a href='#'> Disposal</a></li>
		<li><a href='#' id='current'>Supplier</a></li>
		<li><a href='#'> Reports</a></li>
	</ul> ";
}
else if ($currentpage == "reports")
{
	echo "
	<ul>
		<li><a href='index.php'> Dashboard </a></li>
		<li><a href='po.php'> PO</a></li>
		<li><a href='#'>Receiving</a></li>
		<li><a href='#'> Disb Voucher</a></li>
		<li><a href='#'> Issuance</a></li>
		<li><a href='#'> Disposal</a></li>
		<li><a href='#'>Supplier</a></li>
		<li><a href='#' id='current'> Reports</a></li>
	</ul> ";
}



?>