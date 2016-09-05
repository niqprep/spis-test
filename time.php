<?php 
$a='H';
$hour= date("h");
$h=$hour+1;
$minuite=date(":i:");
$seconds=date("s");


if (($hour>=1) && ($hour <=4)){
$newhour=$hour+8;


} else if(($hour>=5)&&($hour<=12)){
$newhour=$hour-4;


}


echo "<h2>$newhour$minuite$seconds$type</h2>";







?>

