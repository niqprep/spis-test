<?php
$currentpage = $_SESSION['currentpage'];

?>

<div id='cssmenu'>
<link rel="stylesheet" href="cssmenu/styles.css">
<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="script.js"></script>
<ul>
   <li
	   <?php
		   if ($currentpage == "dashboard"){
			   echo "class='active'";
			}
	   ?>   
  
   ><a href='index.php' >Dashboard</a>
	</li>


	  <li  
		<?php //issuance changed to stocks
	   if ($currentpage == "po"){
		   echo "class='active'";
	   }
		?>  ><a href='#'>Purchase Order</a>

		<ul>               
			   	<li><a href='po.php' target="new">Create PO</a></li>
			   	<li><a href='pr.php' target="new">Log PR</a></li>
               	<li><a href='searchpo.php'>Manage PO</a></li>
               	<li><a href='prlist.php'>PR List</a></li>
               	<li><a href='po.php'>test1</a>
               		<ul>
               		<li><a href='#'>Create PO</a></li>
               		<li><a href='#'>Search PO</a></li>
               		<li><a href='#'>PR List</a></li>

               		</ul>
             	</li>
        </ul>

</li>
   <li  
		<?php //issuance changed to stocks
	   if ($currentpage == "issuance"){
		   echo "class='active'";
	   }
		?>  ><a href='#'>Issuance</a>

		<ul>
              	<li><a href='issuehkofc.php'>HK / Ofc Supp</a></li>
               	<li><a href='selcat2.php'>Other Supplies</a></li>
               	
        </ul>

	</li>
	<li  
		<?php //issuance changed to stocks
	   if ($currentpage == "view"){
		   echo "class='active'";
	   }
		?>  ><a href='#'>View Stocks</a>

		<ul>
              <li><a href='bincard.php?cat=HK'>House Keeping</a></li>
              <li><a href='bincard.php?cat=OS'>Office Supplies</a></li>
			  <li><a href='selcat3.php'>Other Supplies</a></li>
               	
        </ul>

	</li>



 
   <li <?php
	   if ($currentpage == "supplier"){
		   echo "class='active'";
	   }
	?>  class='has-sub'><a href='#'>Supplier</a>
		<ul>
			 <li><a href='supp.php'>Search Supplier</a></li>
			 <li><a href='addsupp.php'>Add new Supplier</a></li>
			
      </ul>
	</li>


	<li <?php
		   if ($currentpage == "admin"){
			   echo "class='active'";
		   }
		?>  class='has-sub'><a href='admin.php'>Admin</a>
      <ul>
         <li><a href='selcat.php'>Add Stock</a></li>
		 <li><a href='additem.php'>Add New Item</a></li>
		 <li><a href='dept.php'>Department</a></li>
		 <li><a href='ppmp.php'>PPMP</a></li>
		 <li><a href='#'>Reports</a></li>
      </ul>
   </li>

	



   <!-- <li><a href='#'>About</a></li> -->
   <li><a href='logout.php' onclick="return confirm('Are you sure you want to log out?');" >Log out</a></li>
</ul>
</div>