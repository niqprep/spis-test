<?php 
function convert_number_to_words($number) {
    
    $hyphen      = ' ';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
                '01' => "one", 
                '02' => "two", 
                '03' => "three", 
                '04' => "four", 
                '05' => "five", 
                '06' => "six", 
                '07' => "seven", 
                '08' => "eight", 
                '09' => "nine", 
        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    
    return $string;
}

?>



<?php 
/*********************************************** 
* Script Name : NumToWords * 
* Scripted By : Alex Culango * 
* Email : itnapster.som@gmail.com * 
***********************************************/ 
function numtowords2($num){ 
    $decones = array( 
                '01' => "One", 
                '02' => "Two", 
                '03' => "Three", 
                '04' => "Four", 
                '05' => "Five", 
                '06' => "Six", 
                '07' => "Seven", 
                '08' => "Eight", 
                '09' => "Nine", 
                10 => "Ten", 
                11 => "Eleven", 
                12 => "Twelve", 
                13 => "Thirteen", 
                14 => "Fourteen", 
                15 => "Fifteen", 
                16 => "Sixteen", 
                17 => "Seventeen", 
                18 => "Eighteen", 
                19 => "Nineteen" 
                );
    $ones = array( 
                0 => " ",
                1 => "One",     
                2 => "Two", 
                3 => "Three", 
                4 => "Four", 
                5 => "Five", 
                6 => "Six", 
                7 => "Seven", 
                8 => "Eight", 
                9 => "Nine", 
                10 => "Ten", 
                11 => "Eleven", 
                12 => "Twelve", 
                13 => "Thirteen", 
                14 => "Fourteen", 
                15 => "Fifteen", 
                16 => "Sixteen", 
                17 => "Seventeen", 
                18 => "Eighteen", 
                19 => "Nineteen" 
                ); 
    $tens = array( 
                0 => " ",
                2 => "Twenty", 
                3 => "Thirty", 
                4 => "Forty", 
                5 => "Fifty", 
                6 => "Sixty", 
                7 => "Seventy", 
                8 => "Eighty", 
                9 => "Ninety" 
                ); 
    $hundreds = array( 
                "Hundred", 
                "Thousand", 
                "Million", 
                "Billion", 
                "Trillion", 
                "Quadrillion" 
                ); //limit t quadrillion 
    $num = number_format($num,2,".",","); 
    $num_arr = explode(".",$num); 
    $wholenum = $num_arr[0]; 
    $decnum = $num_arr[1]; 
    $whole_arr = array_reverse(explode(",",$wholenum)); 
    krsort($whole_arr); 
    $rettxt = ""; 
    foreach($whole_arr as $key => $i){ 
        if($i < 20){ 
            //orig - $rettxt .= $ones[$i]; 
            //start edit 4/27/2016
           if ($i == "000")
            {

            }
            else
            {
                $rettxt .= $ones[$i]; 
            }
            //end edit 4/27/2016
        }
        elseif($i < 100){ 
            $rettxt .= $tens[substr($i,0,1)]; 
            $rettxt .= " ".$ones[substr($i,1,1)]; 
        }
        else{ 
            $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
            //orig - $rettxt .= " ".$tens[substr($i,1,1)]; 
            //       $rettxt .= " ".$ones[substr($i,2,1)]; 
            //start edit 4/27/2016
            if (substr($i,1,2) < 20 ) {
                 if (substr($i,1,2) == "00")
                {

                }
                else
                {
                 $rettxt .= " ".$ones[substr($i,1,2)];
                }
                
            }
            else
            {
                $rettxt .= " ".$tens[substr($i,1,1)]; 
                $rettxt .= " ".$ones[substr($i,2,1)]; 
            }
            //end edit 4/27/2016
            
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
    krsort($whole_arr); 
    $rettxt = ""; 
    foreach($whole_arr as $key => $i){ 
        
        
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

 
/*********************************************** 
* Script Name : ucfirst_sentence * 
* Scripted By : MPP * 
* Email : nicprep@ymail.com * 
* Details: Capitalize the first letter in the word 
***********************************************/ 
function ucfirst_sentence($str) 
{ 
    $str = strtolower($str);
    return preg_replace('/\b(\w)/e', 'strtoupper("$1")', $str); 
} 




/*********************************************** 
* Script Name : cleanthis * 
* Scripted By : MPP * 
* Email : nicprep@ymail.com * 
* Details: Disinfects and removes sql injection from user input
***********************************************/ 
function cleanthis($inp)
{
    $inp = mysql_real_escape_string(htmlspecialchars(strip_tags(trim($inp))));
    return $inp;
}  


function chkactive($bin)
{
    if ($bin == '1') 
    {
        $bidstat = "Active";
    }
    else
    {
        $bidstat = "Inactive";
    }
    return $bidstat; 
}


function count_negatives($array) {
    $i = 0;
    foreach ($array as $x)
        if ($x < 0) $i++;
    return $i;
}