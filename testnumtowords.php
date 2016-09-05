<?php 
/*********************************************** 
* Script Name : NumToWords * 
* Tailored By : Monique Prepose * 
* Email : nicprep@ymail.com * 
* version : 2 *
***********************************************/ 
function numtowords($num){ 
	$decones = array( 
				'01' => "one", 
				'02' => "two", 
				'03' => "three", 
				'04' => "four", 
				'05' => "five", 
				'06' => "six", 
				'07' => "seven", 
				'08' => "eight", 
				'09' => "nine", 
				10 => "ten", 
				11 => "eleven", 
				12 => "twelve", 
				13 => "thirteen", 
				14 => "fourteen", 
				15 => "fifteen", 
				16 => "sixteen", 
				17 => "seventeen", 
				18 => "eighteen", 
				19 => "nineteen" 
				);
	$ones = array( 
				0 => " ",
				1 => "one", 	
				2 => "two", 
				3 => "three", 
				4 => "four", 
				5 => "five", 
				6 => "six", 
				7 => "seven", 
				8 => "eight", 
				9 => "nine", 
				10 => "ten", 
				11 => "eleven", 
				12 => "twelve", 
				13 => "thirteen", 
				14 => "fourteen", 
				15 => "fifteen", 
				16 => "sixteen", 
				17 => "seventeen", 
				18 => "eighteen", 
				19 => "nineteen" 
				); 
	$tens = array( 
				0 => "",
				2 => "twenty", 
				3 => "thirty", 
				4 => "forty", 
				5 => "fifty", 
				6 => "sixty", 
				7 => "seventy", 
				8 => "eighty", 
				9 => "ninety" 
				); 
	$hundreds = array( 
				"hundred", 
				"thousand", 
				"million", 
				"billion", 
				"trillion", 
				"quadrillion" 
				); //limit t quadrillion 
	$num = number_format($num,2,".",","); 
	$num_arr = explode(".",$num); 
	$wholenum = $num_arr[0]; 
	$decnum = $num_arr[1]; 
	$whole_arr = array_reverse(explode(",",$wholenum)); 
	print_r($whole_arr = array_reverse(explode(",",$wholenum))); echo ' -A<br>'; //nic//////////////////////////////////////A
	krsort($whole_arr); 
	print_r( krsort($whole_arr));  echo ' -B<br>'; //nic/////////////////////////////////////////////////////////////////////B

	$rettxt = ""; 
	foreach($whole_arr as $key => $i){ 
		print_r($key); echo ' -C<br>'; //nic/////////////////////////////////////////////////////////////////////////////////C
		echo $i;
		if($i < 20){ 
			if (substr($i,0,1) == '0') //if zero ang una i.e. 12,077 -zero ung sa hundreds
			{
				if ($i >= 10) //if one ung sa tens nya  12017
				{
					$rettxt .= $ones[substr($i,1,2)]; 
					//$rettxt .= " ".$ones[substr($i,2,1)];
				}
				else
				{
					$rettxt .= $tens[substr($i,1,1)]; 
					$rettxt .= " ".$ones[substr($i,2,1)];
				} 		
			}
			else
			{

			$rettxt .= $ones[$i]; 
			}
		}
		elseif($i < 100){ 
			//substr(string,start,length)
			if (substr($i,0,1) == '0') //if zero ang una i.e. 12,077 -zero ung sa hundreds
			{
				$rettxt .= $tens[substr($i,1,1)]; 
				$rettxt .= " ".$ones[substr($i,2,1)]; 		
			}
			else
			{
				$rettxt .= $tens[substr($i,0,1)]; 
				$rettxt .= " ".$ones[substr($i,1,1)]; 
		
			}	
		}
		elseif ($i < 1000) {
			$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
			
			if (substr($i,1,1) == '1') 
			{
				$rettxt .= " ".$ones[substr($i,1,2)]; 
			}
			else
			{
				$rettxt .= " ".$tens[substr($i,1,1)]; 
				$rettxt .= " ".$ones[substr($i,2,1)]; 
			}
			
		}
		else{ 
			$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
			$rettxt .= " ".$tens[substr($i,1,1)]; 
			$rettxt .= " ".$ones[substr($i,2,1)]; 
		} 
		if($key > 0){ 
			$rettxt .= " ".$hundreds[$key]." "; 
		} 

	} 
	$rettxt = $rettxt." peso/s";

	if($decnum > 0){ 
		$rettxt .= " and "; 
		if($decnum < 20){ 
			$rettxt .= $decones[$decnum]; 
		}
		elseif($decnum < 100){ 
			$rettxt .= $tens[substr($decnum,0,1)]; 
			$rettxt .= " ".$ones[substr($decnum,1,1)]; 
		}
		$rettxt = $rettxt." centavo/s"; 
	} 
	return $rettxt; 
} 


echo numtowords("1121111.20"); //12027   12007   12017   12011.20
echo "<br>";




$date = date('Y-m-d');
$date1 = new DateTime($date);
$date2 = new DateTime("2015-04-10");
$interval = $date1->diff($date2);
echo "<br> difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 

// shows the total amount of days (not divided into years, months and days like above)
echo " difference " . $interval->days . " days ";
?>

