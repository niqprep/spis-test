<?php
$a=array("red","green");
array_push($a,"blue","yellow");
print_r($a);
?>


<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ITRMC - Supply & Property System</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/styleissue.css" rel="stylesheet" type="text/css" />
		<script src="js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {	

					var id = '#dialog';
				
					//Get the screen height and width
					var maskHeight = $(document).height();
					var maskWidth = $(window).width();
				
					//Set heigth and width to mask to fill up the whole screen
					$('#mask').css({'width':maskWidth,'height':maskHeight});
					
					//transition effect		
					$('#mask').fadeIn(1000);	
					$('#mask').fadeTo("slow",0.8);	
				
					//Get the window height and width
					var winH = $(window).height();
					var winW = $(window).width();
						  
					//Set the popup window to center
					$(id).css('top',  winH/2-$(id).height()/2);
					$(id).css('left', winW/2-$(id).width()/2);
				
					//transition effect
					$(id).fadeIn(1000); 	
				
				
			});

		</script>
	</head>

<body >
<?php
echo '<div id="wholepage">
';		


			include 'header.php';

echo '<div id="mbody">';
#start of box#################################	
echo'		<div id="boxes">
				<div id="dialog" class="window">
				Confirm 
				<form name="issuedet" id="issueform" method="post" action="#">
					
					
					<table id="record2">
						<tr id="heading2"> 
							<td> Field Name</td>
							<td>Previous Data</td>
							<td>New Value</td>
							
						</tr>
					</table>';

				echo '	
					<div class="containeredit">

						<input type="hidden" name="ctritems" value="" />
						<input type="hidden" name="type" value="" />

						<table id="record3">';
							
					echo '	<tr > 
								<td>
									Item Name
								</td>
								<td >
									Old value
								</td>
								<td>
									New value
								</td>
								
							</tr>';
								   		
								   		
				echo'	</table>				
					</div>

					';

	echo '			
					<input type="submit" value="Save" />					<button onClick="history.go(-1);">Back</button>
				</form>
				</div> 
				
				<div id="mask"></div>
			</div>';
	#end of box ################################



	echo '
		<h2><a href="bincard.php?cat=" onClick="history.go(-1);">View Item</a> > Edit Item > </h2>';
			
			include 'footer.php';
?>

</div>

<script src="js/angular.min.js"></script>									

</body>
</html> 