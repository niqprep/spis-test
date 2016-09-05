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


  <!--  
ORIG
  <li  
		<?php //issuance changed to stocks
	   if ($currentpage == "issuance"){
		   echo "class='active'";
	   }
		?>  ><a href='#'>Stocks</a>

		<ul>
               <li><a href='#'>Issuance</a>
               		<ul>
               		<li><a href='issuehkofc.php'>HK / Ofc Supp</a></li>
               		<li><a href='selcat2.php'>Other Supplies</a></li>
               		<li>              		</li>

               		</ul>
             	</li>
			   <li><a href='bincard.php'>View Bincard</a></li>
			   <li><a href='selcat3.php'>View Stockcard</a></li>
        </ul>

	</li>
 -->
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
		?>  class='has-sub'><a href='#'>Admin</a>
      <ul>
         <li><a href='selcat.php'>Add Stock</a></li>
		 <li><a href='additem.php'>Add New Item</a></li>
		 <li><a href='dept.php'>Department</a></li>
		 <li><a href='#'>Reports</a></li>
      </ul>
   </li>

	



   <!-- <li><a href='#'>About</a></li> -->
   <li><a href='logout.php' onclick="return confirm('Are you sure you want to log out?');" >Log out</a></li>
</ul>
</div>