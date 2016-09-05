
<script language="javascript" type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>


<script language="javascript">AC_FL_RunContent = 0;</script>
<script src="AC_RunActiveContent.js" language="javascript"></script>


<table align="center" cellpadding="0" cellspacing="0"><tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('chem','','images/menu/chemicals-hover.gif',1) href='products.php?djnic=3&chem=1&prod=0'  ><img border='0' name=chem onLoad=MM_preloadImages('images/menu/chemicals-hover.gif') border=0 src=images/menu/chemicals.gif></a>
 <?php 
 if ($prod==1){
 echo "
<br /></td></tr>
<tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('air','','images/menu/air.gif',1) href='products.php?djnic=3&chem=0&prod=1'  ><img border='0' name=air onLoad=MM_preloadImages('images/menu/air.gif') border=0 src=images/menu/air-hover.gif></a></td></tr><tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('carpet','','images/menu/carpet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=2'  ><img border='0' name=carpet onLoad=MM_preloadImages('images/menu/carpet-hover.gif') border=0 src=images/menu/carpet.gif></a></td></tr>
<tr><td><a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('emulsion','','images/menu/emulsion-hover.gif',1) href='products.php?djnic=3&chem=0&prod=3'  ><img border='0' name=emulsion onLoad=MM_preloadImages('images/menu/emulsion-hover.gif') border=0 src=images/menu/emulsion.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('red','','images/menu/red-hover.gif',1) href='products.php?djnic=3&chem=0&prod=4'  ><img border='0' name=red onLoad=MM_preloadImages('images/menu/red-hover.gif') border=0 src=images/menu/red.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('furniture','','images/menu/furniture-hover.gif',1) href='products.php?djnic=3&chem=0&prod=5'  ><img border='0' name=furniture onLoad=MM_preloadImages('images/menu/furniture-hover.gif') border=0 src=images/menu/furniture.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('glass','','images/menu/glass-hover.gif',1) href='products.php?djnic=3&chem=0&prod=6'  ><img border='0' name=glass onLoad=MM_preloadImages('images/menu/glass-hover.gif') border=0 src=images/menu/glass.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('kleenerox','','images/menu/kleenerox-hover.gif',1) href='products.php?djnic=3&chem=0&prod=7'  ><img border='0' name=kleenerox onLoad=MM_preloadImages('images/menu/kleenerox-hover.gif') border=0 src=images/menu/kleenerox.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('marble','','images/menu/marble-hover.gif',1) href='products.php?djnic=3&chem=0&prod=8'  ><img border='0' name=marble onLoad=MM_preloadImages('images/menu/marble-hover.gif') border=0 src=images/menu/marble.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('disinfectant','','images/menu/disinfectant-hover.gif',1) href='products.php?djnic=3&chem=0&prod=9'  ><img border='0' name=disinfectant onLoad=MM_preloadImages('images/menu/disinfectant-hover.gif') border=0 src=images/menu/disinfectant.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('toilet','','images/menu/toilet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=10'  ><img border='0' name=toilet onLoad=MM_preloadImages('images/menu/toilet-hover.gif') border=0 src=images/menu/toilet.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('wax','','images/menu/wax-hover.gif',1) href='products.php?djnic=3&chem=0&prod=11'  ><img border='0' name=wax onLoad=MM_preloadImages('images/menu/wax-hover.gif') border=0 src=images/menu/wax.gif></a></td></tr>";}
 
 if ($prod==2){
 echo "
<br /></td></tr>
<tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('air','','images/menu/air-hover.gif',1) href='products.php?djnic=3&chem=0&prod=1'  ><img border='0' name=air onLoad=MM_preloadImages('images/menu/air-hover.gif') border=0 src=images/menu/air.gif></a></td></tr><tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('carpet','','images/menu/carpet.gif',1) href='products.php?djnic=3&chem=0&prod=2'  ><img border='0' name=carpet onLoad=MM_preloadImages('images/menu/carpet.gif') border=0 src=images/menu/carpet-hover.gif></a></td></tr>
<tr><td><a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('emulsion','','images/menu/emulsion-hover.gif',1) href='products.php?djnic=3&chem=0&prod=3'  ><img border='0' name=emulsion onLoad=MM_preloadImages('images/menu/emulsion-hover.gif') border=0 src=images/menu/emulsion.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('red','','images/menu/red-hover.gif',1) href='products.php?djnic=3&chem=0&prod=4'  ><img border='0' name=red onLoad=MM_preloadImages('images/menu/red-hover.gif') border=0 src=images/menu/red.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('furniture','','images/menu/furniture-hover.gif',1) href='products.php?djnic=3&chem=0&prod=5'  ><img border='0' name=furniture onLoad=MM_preloadImages('images/menu/furniture-hover.gif') border=0 src=images/menu/furniture.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('glass','','images/menu/glass-hover.gif',1) href='products.php?djnic=3&chem=0&prod=6'  ><img border='0' name=glass onLoad=MM_preloadImages('images/menu/glass-hover.gif') border=0 src=images/menu/glass.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('kleenerox','','images/menu/kleenerox-hover.gif',1) href='products.php?djnic=3&chem=0&prod=7'  ><img border='0' name=kleenerox onLoad=MM_preloadImages('images/menu/kleenerox-hover.gif') border=0 src=images/menu/kleenerox.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('marble','','images/menu/marble-hover.gif',1) href='products.php?djnic=3&chem=0&prod=8'  ><img border='0' name=marble onLoad=MM_preloadImages('images/menu/marble-hover.gif') border=0 src=images/menu/marble.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('disinfectant','','images/menu/disinfectant-hover.gif',1) href='products.php?djnic=3&chem=0&prod=9'  ><img border='0' name=disinfectant onLoad=MM_preloadImages('images/menu/disinfectant-hover.gif') border=0 src=images/menu/disinfectant.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('toilet','','images/menu/toilet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=10'  ><img border='0' name=toilet onLoad=MM_preloadImages('images/menu/toilet-hover.gif') border=0 src=images/menu/toilet.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('wax','','images/menu/wax-hover.gif',1) href='products.php?djnic=3&chem=0&prod=11'  ><img border='0' name=wax onLoad=MM_preloadImages('images/menu/wax-hover.gif') border=0 src=images/menu/wax.gif></a></td></tr>";
 }
 if ($prod==3){
 echo "
<br /></td></tr>
<tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('air','','images/menu/air-hover.gif',1) href='products.php?djnic=3&chem=0&prod=1'  ><img border='0' name=air onLoad=MM_preloadImages('images/menu/air-hover.gif') border=0 src=images/menu/air.gif></a></td></tr><tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('carpet','','images/menu/carpet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=2'  ><img border='0' name=carpet onLoad=MM_preloadImages('images/menu/carpet-hover.gif') border=0 src=images/menu/carpet.gif></a></td></tr>
<tr><td><a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('emulsion','','images/menu/emulsion.gif',1) href='products.php?djnic=3&chem=0&prod=3'  ><img border='0' name=emulsion onLoad=MM_preloadImages('images/menu/emulsion.gif') border=0 src=images/menu/emulsion-hover.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('red','','images/menu/red-hover.gif',1) href='products.php?djnic=3&chem=0&prod=4'  ><img border='0' name=red onLoad=MM_preloadImages('images/menu/red-hover.gif') border=0 src=images/menu/red.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('furniture','','images/menu/furniture-hover.gif',1) href='products.php?djnic=3&chem=0&prod=5'  ><img border='0' name=furniture onLoad=MM_preloadImages('images/menu/furniture-hover.gif') border=0 src=images/menu/furniture.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('glass','','images/menu/glass-hover.gif',1) href='products.php?djnic=3&chem=0&prod=6'  ><img border='0' name=glass onLoad=MM_preloadImages('images/menu/glass-hover.gif') border=0 src=images/menu/glass.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('kleenerox','','images/menu/kleenerox-hover.gif',1) href='products.php?djnic=3&chem=0&prod=7'  ><img border='0' name=kleenerox onLoad=MM_preloadImages('images/menu/kleenerox-hover.gif') border=0 src=images/menu/kleenerox.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('marble','','images/menu/marble-hover.gif',1) href='products.php?djnic=3&chem=0&prod=8'  ><img border='0' name=marble onLoad=MM_preloadImages('images/menu/marble-hover.gif') border=0 src=images/menu/marble.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('disinfectant','','images/menu/disinfectant-hover.gif',1) href='products.php?djnic=3&chem=0&prod=9'  ><img border='0' name=disinfectant onLoad=MM_preloadImages('images/menu/disinfectant-hover.gif') border=0 src=images/menu/disinfectant.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('toilet','','images/menu/toilet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=10'  ><img border='0' name=toilet onLoad=MM_preloadImages('images/menu/toilet-hover.gif') border=0 src=images/menu/toilet.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('wax','','images/menu/wax-hover.gif',1) href='products.php?djnic=3&chem=0&prod=11'  ><img border='0' name=wax onLoad=MM_preloadImages('images/menu/wax-hover.gif') border=0 src=images/menu/wax.gif></a></td></tr>";
 }
 if ($prod==4){
 echo "
<br /></td></tr>
<tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('air','','images/menu/air-hover.gif',1) href='products.php?djnic=3&chem=0&prod=1'  ><img border='0' name=air onLoad=MM_preloadImages('images/menu/air-hover.gif') border=0 src=images/menu/air.gif></a></td></tr><tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('carpet','','images/menu/carpet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=2'  ><img border='0' name=carpet onLoad=MM_preloadImages('images/menu/carpet-hover.gif') border=0 src=images/menu/carpet.gif></a></td></tr>
<tr><td><a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('emulsion','','images/menu/emulsion-hover.gif',1) href='products.php?djnic=3&chem=0&prod=3'  ><img border='0' name=emulsion onLoad=MM_preloadImages('images/menu/emulsion-hover.gif') border=0 src=images/menu/emulsion.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('red','','images/menu/red.gif',1) href='products.php?djnic=3&chem=0&prod=4'  ><img border='0' name=red onLoad=MM_preloadImages('images/menu/red.gif') border=0 src=images/menu/red-hover.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('furniture','','images/menu/furniture-hover.gif',1) href='products.php?djnic=3&chem=0&prod=5'  ><img border='0' name=furniture onLoad=MM_preloadImages('images/menu/furniture-hover.gif') border=0 src=images/menu/furniture.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('glass','','images/menu/glass-hover.gif',1) href='products.php?djnic=3&chem=0&prod=6'  ><img border='0' name=glass onLoad=MM_preloadImages('images/menu/glass-hover.gif') border=0 src=images/menu/glass.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('kleenerox','','images/menu/kleenerox-hover.gif',1) href='products.php?djnic=3&chem=0&prod=7'  ><img border='0' name=kleenerox onLoad=MM_preloadImages('images/menu/kleenerox-hover.gif') border=0 src=images/menu/kleenerox.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('marble','','images/menu/marble-hover.gif',1) href='products.php?djnic=3&chem=0&prod=8'  ><img border='0' name=marble onLoad=MM_preloadImages('images/menu/marble-hover.gif') border=0 src=images/menu/marble.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('disinfectant','','images/menu/disinfectant-hover.gif',1) href='products.php?djnic=3&chem=0&prod=9'  ><img border='0' name=disinfectant onLoad=MM_preloadImages('images/menu/disinfectant-hover.gif') border=0 src=images/menu/disinfectant.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('toilet','','images/menu/toilet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=10'  ><img border='0' name=toilet onLoad=MM_preloadImages('images/menu/toilet-hover.gif') border=0 src=images/menu/toilet.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('wax','','images/menu/wax-hover.gif',1) href='products.php?djnic=3&chem=0&prod=11'  ><img border='0' name=wax onLoad=MM_preloadImages('images/menu/wax-hover.gif') border=0 src=images/menu/wax.gif></a></td></tr>";
 }
 if ($prod==5){
 echo "
<br /></td></tr>
<tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('air','','images/menu/air-hover.gif',1) href='products.php?djnic=3&chem=0&prod=1'  ><img border='0' name=air onLoad=MM_preloadImages('images/menu/air-hover.gif') border=0 src=images/menu/air.gif></a></td></tr><tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('carpet','','images/menu/carpet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=2'  ><img border='0' name=carpet onLoad=MM_preloadImages('images/menu/carpet-hover.gif') border=0 src=images/menu/carpet.gif></a></td></tr>
<tr><td><a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('emulsion','','images/menu/emulsion-hover.gif',1) href='products.php?djnic=3&chem=0&prod=3'  ><img border='0' name=emulsion onLoad=MM_preloadImages('images/menu/emulsion-hover.gif') border=0 src=images/menu/emulsion.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('red','','images/menu/red-hover.gif',1) href='products.php?djnic=3&chem=0&prod=4'  ><img border='0' name=red onLoad=MM_preloadImages('images/menu/red-hover.gif') border=0 src=images/menu/red.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('furniture','','images/menu/furniture.gif',1) href='products.php?djnic=3&chem=0&prod=5'  ><img border='0' name=furniture onLoad=MM_preloadImages('images/menu/furniture.gif') border=0 src=images/menu/furniture-hover.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('glass','','images/menu/glass-hover.gif',1) href='products.php?djnic=3&chem=0&prod=6'  ><img border='0' name=glass onLoad=MM_preloadImages('images/menu/glass-hover.gif') border=0 src=images/menu/glass.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('kleenerox','','images/menu/kleenerox-hover.gif',1) href='products.php?djnic=3&chem=0&prod=7'  ><img border='0' name=kleenerox onLoad=MM_preloadImages('images/menu/kleenerox-hover.gif') border=0 src=images/menu/kleenerox.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('marble','','images/menu/marble-hover.gif',1) href='products.php?djnic=3&chem=0&prod=8'  ><img border='0' name=marble onLoad=MM_preloadImages('images/menu/marble-hover.gif') border=0 src=images/menu/marble.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('disinfectant','','images/menu/disinfectant-hover.gif',1) href='products.php?djnic=3&chem=0&prod=9'  ><img border='0' name=disinfectant onLoad=MM_preloadImages('images/menu/disinfectant-hover.gif') border=0 src=images/menu/disinfectant.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('toilet','','images/menu/toilet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=10'  ><img border='0' name=toilet onLoad=MM_preloadImages('images/menu/toilet-hover.gif') border=0 src=images/menu/toilet.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('wax','','images/menu/wax-hover.gif',1) href='products.php?djnic=3&chem=0&prod=11'  ><img border='0' name=wax onLoad=MM_preloadImages('images/menu/wax-hover.gif') border=0 src=images/menu/wax.gif></a></td></tr>";
 }
 if ($prod==6){
 echo "
<br /></td></tr>
<tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('air','','images/menu/air-hover.gif',1) href='products.php?djnic=3&chem=0&prod=1'  ><img border='0' name=air onLoad=MM_preloadImages('images/menu/air-hover.gif') border=0 src=images/menu/air.gif></a></td></tr><tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('carpet','','images/menu/carpet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=2'  ><img border='0' name=carpet onLoad=MM_preloadImages('images/menu/carpet-hover.gif') border=0 src=images/menu/carpet.gif></a></td></tr>
<tr><td><a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('emulsion','','images/menu/emulsion-hover.gif',1) href='products.php?djnic=3&chem=0&prod=3'  ><img border='0' name=emulsion onLoad=MM_preloadImages('images/menu/emulsion-hover.gif') border=0 src=images/menu/emulsion.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('red','','images/menu/red-hover.gif',1) href='products.php?djnic=3&chem=0&prod=4'  ><img border='0' name=red onLoad=MM_preloadImages('images/menu/red-hover.gif') border=0 src=images/menu/red.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('furniture','','images/menu/furniture-hover.gif',1) href='products.php?djnic=3&chem=0&prod=5'  ><img border='0' name=furniture onLoad=MM_preloadImages('images/menu/furniture-hover.gif') border=0 src=images/menu/furniture.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('glass','','images/menu/glass.gif',1) href='products.php?djnic=3&chem=0&prod=6'  ><img border='0' name=glass onLoad=MM_preloadImages('images/menu/glass.gif') border=0 src=images/menu/glass-hover.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('kleenerox','','images/menu/kleenerox-hover.gif',1) href='products.php?djnic=3&chem=0&prod=7'  ><img border='0' name=kleenerox onLoad=MM_preloadImages('images/menu/kleenerox-hover.gif') border=0 src=images/menu/kleenerox.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('marble','','images/menu/marble-hover.gif',1) href='products.php?djnic=3&chem=0&prod=8'  ><img border='0' name=marble onLoad=MM_preloadImages('images/menu/marble-hover.gif') border=0 src=images/menu/marble.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('disinfectant','','images/menu/disinfectant-hover.gif',1) href='products.php?djnic=3&chem=0&prod=9'  ><img border='0' name=disinfectant onLoad=MM_preloadImages('images/menu/disinfectant-hover.gif') border=0 src=images/menu/disinfectant.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('toilet','','images/menu/toilet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=10'  ><img border='0' name=toilet onLoad=MM_preloadImages('images/menu/toilet-hover.gif') border=0 src=images/menu/toilet.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('wax','','images/menu/wax-hover.gif',1) href='products.php?djnic=3&chem=0&prod=11'  ><img border='0' name=wax onLoad=MM_preloadImages('images/menu/wax-hover.gif') border=0 src=images/menu/wax.gif></a></td></tr>";
 }
 if ($prod==7){
 echo "
<br /></td></tr>
<tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('air','','images/menu/air-hover.gif',1) href='products.php?djnic=3&chem=0&prod=1'  ><img border='0' name=air onLoad=MM_preloadImages('images/menu/air-hover.gif') border=0 src=images/menu/air.gif></a></td></tr><tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('carpet','','images/menu/carpet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=2'  ><img border='0' name=carpet onLoad=MM_preloadImages('images/menu/carpet-hover.gif') border=0 src=images/menu/carpet.gif></a></td></tr>
<tr><td><a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('emulsion','','images/menu/emulsion-hover.gif',1) href='products.php?djnic=3&chem=0&prod=3'  ><img border='0' name=emulsion onLoad=MM_preloadImages('images/menu/emulsio-hovern.gif') border=0 src=images/menu/emulsion.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('red','','images/menu/red-hover.gif',1) href='products.php?djnic=3&chem=0&prod=4'  ><img border='0' name=red onLoad=MM_preloadImages('images/menu/red-hover.gif') border=0 src=images/menu/red.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('furniture','','images/menu/furniture-hover.gif',1) href='products.php?djnic=3&chem=0&prod=5'  ><img border='0' name=furniture onLoad=MM_preloadImages('images/menu/furniture-hover.gif') border=0 src=images/menu/furniture.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('glass','','images/menu/glass-hover.gif',1) href='products.php?djnic=3&chem=0&prod=6'  ><img border='0' name=glass onLoad=MM_preloadImages('images/menu/glass-hover.gif') border=0 src=images/menu/glass.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('kleenerox','','images/menu/kleenerox.gif',1) href='products.php?djnic=3&chem=0&prod=7'  ><img border='0' name=kleenerox onLoad=MM_preloadImages('images/menu/kleenerox.gif') border=0 src=images/menu/kleenerox-hover.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('marble','','images/menu/marble-hover.gif',1) href='products.php?djnic=3&chem=0&prod=8'  ><img border='0' name=marble onLoad=MM_preloadImages('images/menu/marble-hover.gif') border=0 src=images/menu/marble.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('disinfectant','','images/menu/disinfectant-hover.gif',1) href='products.php?djnic=3&chem=0&prod=9'  ><img border='0' name=disinfectant onLoad=MM_preloadImages('images/menu/disinfectant-hover.gif') border=0 src=images/menu/disinfectant.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('toilet','','images/menu/toilet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=10'  ><img border='0' name=toilet onLoad=MM_preloadImages('images/menu/toilet-hover.gif') border=0 src=images/menu/toilet.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('wax','','images/menu/wax-hover.gif',1) href='products.php?djnic=3&chem=0&prod=11'  ><img border='0' name=wax onLoad=MM_preloadImages('images/menu/wax-hover.gif') border=0 src=images/menu/wax.gif></a></td></tr>";
 }
 if ($prod==8){
 echo "
<br /></td></tr>
<tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('air','','images/menu/air-hover.gif',1) href='products.php?djnic=3&chem=0&prod=1'  ><img border='0' name=air onLoad=MM_preloadImages('images/menu/air-hover.gif') border=0 src=images/menu/air.gif></a></td></tr><tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('carpet','','images/menu/carpet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=2'  ><img border='0' name=carpet onLoad=MM_preloadImages('images/menu/carpet-hover.gif') border=0 src=images/menu/carpet.gif></a></td></tr>
<tr><td><a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('emulsion','','images/menu/emulsion-hover.gif',1) href='products.php?djnic=3&chem=0&prod=3'  ><img border='0' name=emulsion onLoad=MM_preloadImages('images/menu/emulsion-hover.gif') border=0 src=images/menu/emulsion.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('red','','images/menu/red-hover.gif',1) href='products.php?djnic=3&chem=0&prod=4'  ><img border='0' name=red onLoad=MM_preloadImages('images/menu/red-hover.gif') border=0 src=images/menu/red.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('furniture','','images/menu/furniture-hover.gif',1) href='products.php?djnic=3&chem=0&prod=5'  ><img border='0' name=furniture onLoad=MM_preloadImages('images/menu/furniture-hover.gif') border=0 src=images/menu/furniture.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('glass','','images/menu/glass-hover.gif',1) href='products.php?djnic=3&chem=0&prod=6'  ><img border='0' name=glass onLoad=MM_preloadImages('images/menu/glass-hover.gif') border=0 src=images/menu/glass.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('kleenerox','','images/menu/kleenerox-hover.gif',1) href='products.php?djnic=3&chem=0&prod=7'  ><img border='0' name=kleenerox onLoad=MM_preloadImages('images/menu/kleenerox-hover.gif') border=0 src=images/menu/kleenerox.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('marble','','images/menu/marble.gif',1) href='products.php?djnic=3&chem=0&prod=8'  ><img border='0' name=marble onLoad=MM_preloadImages('images/menu/marble.gif') border=0 src=images/menu/marble-hover.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('disinfectant','','images/menu/disinfectant-hover.gif',1) href='products.php?djnic=3&chem=0&prod=9'  ><img border='0' name=disinfectant onLoad=MM_preloadImages('images/menu/disinfectant-hover.gif') border=0 src=images/menu/disinfectant.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('toilet','','images/menu/toilet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=10'  ><img border='0' name=toilet onLoad=MM_preloadImages('images/menu/toilet-hover.gif') border=0 src=images/menu/toilet.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('wax','','images/menu/wax-hover.gif',1) href='products.php?djnic=3&chem=0&prod=11'  ><img border='0' name=wax onLoad=MM_preloadImages('images/menu/wax-hover.gif') border=0 src=images/menu/wax.gif></a></td></tr>";
 }
 if ($prod==9){
 echo "
<br /></td></tr>
<tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('air','','images/menu/air-hover.gif',1) href='products.php?djnic=3&chem=0&prod=1'  ><img border='0' name=air onLoad=MM_preloadImages('images/menu/air-hover.gif') border=0 src=images/menu/air.gif></a></td></tr><tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('carpet','','images/menu/carpet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=2'  ><img border='0' name=carpet onLoad=MM_preloadImages('images/menu/carpet-hover.gif') border=0 src=images/menu/carpet.gif></a></td></tr>
<tr><td><a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('emulsion','','images/menu/emulsion-hover.gif',1) href='products.php?djnic=3&chem=0&prod=3'  ><img border='0' name=emulsion onLoad=MM_preloadImages('images/menu/emulsion-hover.gif') border=0 src=images/menu/emulsion.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('red','','images/menu/red-hover.gif',1) href='products.php?djnic=3&chem=0&prod=4'  ><img border='0' name=red onLoad=MM_preloadImages('images/menu/red-hover.gif') border=0 src=images/menu/red.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('furniture','','images/menu/furniture-hover.gif',1) href='products.php?djnic=3&chem=0&prod=5'  ><img border='0' name=furniture onLoad=MM_preloadImages('images/menu/furniture-hover.gif') border=0 src=images/menu/furniture.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('glass','','images/menu/glass-hover.gif',1) href='products.php?djnic=3&chem=0&prod=6'  ><img border='0' name=glass onLoad=MM_preloadImages('images/menu/glass-hover.gif') border=0 src=images/menu/glass.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('kleenerox','','images/menu/kleenerox-hover.gif',1) href='products.php?djnic=3&chem=0&prod=7'  ><img border='0' name=kleenerox onLoad=MM_preloadImages('images/menu/kleenerox-hover.gif') border=0 src=images/menu/kleenerox.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('marble','','images/menu/marble-hover.gif',1) href='products.php?djnic=3&chem=0&prod=8'  ><img border='0' name=marble onLoad=MM_preloadImages('images/menu/marble-hover.gif') border=0 src=images/menu/marble.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('disinfectant','','images/menu/disinfectant.gif',1) href='products.php?djnic=3&chem=0&prod=9'  ><img border='0' name=disinfectant onLoad=MM_preloadImages('images/menu/disinfectant.gif') border=0 src=images/menu/disinfectant-hover.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('toilet','','images/menu/toilet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=10'  ><img border='0' name=toilet onLoad=MM_preloadImages('images/menu/toilet-hover.gif') border=0 src=images/menu/toilet.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('wax','','images/menu/wax-hover.gif',1) href='products.php?djnic=3&chem=0&prod=11'  ><img border='0' name=wax onLoad=MM_preloadImages('images/menu/wax-hover.gif') border=0 src=images/menu/wax.gif></a></td></tr>";
 }
 if ($prod==10){
 echo "
<br /></td></tr>
<tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('air','','images/menu/air-hover.gif',1) href='products.php?djnic=3&chem=0&prod=1'  ><img border='0' name=air onLoad=MM_preloadImages('images/menu/air-hover.gif') border=0 src=images/menu/air.gif></a></td></tr><tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('carpet','','images/menu/carpet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=2'  ><img border='0' name=carpet onLoad=MM_preloadImages('images/menu/carpet-hover.gif') border=0 src=images/menu/carpet.gif></a></td></tr>
<tr><td><a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('emulsion','','images/menu/emulsion-hover.gif',1) href='products.php?djnic=3&chem=0&prod=3'  ><img border='0' name=emulsion onLoad=MM_preloadImages('images/menu/emulsion-hover.gif') border=0 src=images/menu/emulsion.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('red','','images/menu/red-hover.gif',1) href='products.php?djnic=3&chem=0&prod=4'  ><img border='0' name=red onLoad=MM_preloadImages('images/menu/red-hover.gif') border=0 src=images/menu/red.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('furniture','','images/menu/furniture-hover.gif',1) href='products.php?djnic=3&chem=0&prod=5'  ><img border='0' name=furniture onLoad=MM_preloadImages('images/menu/furniture-hover.gif') border=0 src=images/menu/furniture.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('glass','','images/menu/glass-hover.gif',1) href='products.php?djnic=3&chem=0&prod=6'  ><img border='0' name=glass onLoad=MM_preloadImages('images/menu/glass-hover.gif') border=0 src=images/menu/glass.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('kleenerox','','images/menu/kleenerox-hover.gif',1) href='products.php?djnic=3&chem=0&prod=7'  ><img border='0' name=kleenerox onLoad=MM_preloadImages('images/menu/kleenerox-hover.gif') border=0 src=images/menu/kleenerox.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('marble','','images/menu/marble-hover.gif',1) href='products.php?djnic=3&chem=0&prod=8'  ><img border='0' name=marble onLoad=MM_preloadImages('images/menu/marble-hover.gif') border=0 src=images/menu/marble.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('disinfectant','','images/menu/disinfectant-hover.gif',1) href='products.php?djnic=3&chem=0&prod=9'  ><img border='0' name=disinfectant onLoad=MM_preloadImages('images/menu/disinfectant-hover.gif') border=0 src=images/menu/disinfectant.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('toilet','','images/menu/toilet.gif',1) href='products.php?djnic=3&chem=0&prod=10'  ><img border='0' name=toilet onLoad=MM_preloadImages('images/menu/toilet.gif') border=0 src=images/menu/toilet-hover.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('wax','','images/menu/wax-hover.gif',1) href='products.php?djnic=3&chem=0&prod=11'  ><img border='0' name=wax onLoad=MM_preloadImages('images/menu/wax-hover.gif') border=0 src=images/menu/wax.gif></a></td></tr>";
 }
 if ($prod==11){
 echo "
<br /></td></tr>
<tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('air','','images/menu/air-hover.gif',1) href='products.php?djnic=3&chem=0&prod=1'  ><img border='0' name=air onLoad=MM_preloadImages('images/menu/air-hover.gif') border=0 src=images/menu/air.gif></a></td></tr><tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('carpet','','images/menu/carpet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=2'  ><img border='0' name=carpet onLoad=MM_preloadImages('images/menu/carpet-hover.gif') border=0 src=images/menu/carpet.gif></a></td></tr>
<tr><td><a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('emulsion','','images/menu/emulsion-hover.gif',1) href='products.php?djnic=3&chem=0&prod=3'  ><img border='0' name=emulsion onLoad=MM_preloadImages('images/menu/emulsion-hover.gif') border=0 src=images/menu/emulsion.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('red','','images/menu/red-hover.gif',1) href='products.php?djnic=3&chem=0&prod=4'  ><img border='0' name=red onLoad=MM_preloadImages('images/menu/red-hover.gif') border=0 src=images/menu/red.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('furniture','','images/menu/furniture-hover.gif',1) href='products.php?djnic=3&chem=0&prod=5'  ><img border='0' name=furniture onLoad=MM_preloadImages('images/menu/furniture-hover.gif') border=0 src=images/menu/furniture.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('glass','','images/menu/glass-hover.gif',1) href='products.php?djnic=3&chem=0&prod=6'  ><img border='0' name=glass onLoad=MM_preloadImages('images/menu/glass-hover.gif') border=0 src=images/menu/glass.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('kleenerox','','images/menu/kleenerox-hover.gif',1) href='products.php?djnic=3&chem=0&prod=7'  ><img border='0' name=kleenerox onLoad=MM_preloadImages('images/menu/kleenerox-hover.gif') border=0 src=images/menu/kleenerox.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('marble','','images/menu/marble-hover.gif',1) href='products.php?djnic=3&chem=0&prod=8'  ><img border='0' name=marble onLoad=MM_preloadImages('images/menu/marble-hover.gif') border=0 src=images/menu/marble.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('disinfectant','','images/menu/disinfectant-hover.gif',1) href='products.php?djnic=3&chem=0&prod=9'  ><img border='0' name=disinfectant onLoad=MM_preloadImages('images/menu/disinfectant-hover.gif') border=0 src=images/menu/disinfectant.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('toilet','','images/menu/toilet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=10'  ><img border='0' name=toilet onLoad=MM_preloadImages('images/menu/toilet-hover.gif') border=0 src=images/menu/toilet.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('wax','','images/menu/wax.gif',1) href='products.php?djnic=3&chem=0&prod=11'  ><img border='0' name=wax onLoad=MM_preloadImages('images/menu/wax.gif') border=0 src=images/menu/wax-hover.gif></a></td></tr>";
 }
if ($prod==0) {
 echo "
<br /></td></tr>
<tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('air','','images/menu/air-hover.gif',1) href='products.php?djnic=3&chem=0&prod=1'  ><img border='0' name=air onLoad=MM_preloadImages('images/menu/air-hover.gif') border=0 src=images/menu/air.gif></a></td></tr><tr><td>
 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('carpet','','images/menu/carpet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=2'  ><img border='0' name=carpet onLoad=MM_preloadImages('images/menu/carpet-hover.gif') border=0 src=images/menu/carpet.gif></a></td></tr>
<tr><td><a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('emulsion','','images/menu/emulsion-hover.gif',1) href='products.php?djnic=3&chem=0&prod=3'  ><img border='0' name=emulsion onLoad=MM_preloadImages('images/menu/emulsion-hover.gif') border=0 src=images/menu/emulsion.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('red','','images/menu/red-hover.gif',1) href='products.php?djnic=3&chem=0&prod=4'  ><img border='0' name=red onLoad=MM_preloadImages('images/menu/red-hover.gif') border=0 src=images/menu/red.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('furniture','','images/menu/furniture-hover.gif',1) href='products.php?djnic=3&chem=0&prod=5'  ><img border='0' name=furniture onLoad=MM_preloadImages('images/menu/furniture-hover.gif') border=0 src=images/menu/furniture.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('glass','','images/menu/glass-hover.gif',1) href='products.php?djnic=3&chem=0&prod=6'  ><img border='0' name=glass onLoad=MM_preloadImages('images/menu/glass-hover.gif') border=0 src=images/menu/glass.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('kleenerox','','images/menu/kleenerox-hover.gif',1) href='products.php?djnic=3&chem=0&prod=7'  ><img border='0' name=kleenerox onLoad=MM_preloadImages('images/menu/kleenerox-hover.gif') border=0 src=images/menu/kleenerox.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('marble','','images/menu/marble-hover.gif',1) href='products.php?djnic=3&chem=0&prod=8'  ><img border='0' name=marble onLoad=MM_preloadImages('images/menu/marble-hover.gif') border=0 src=images/menu/marble.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('disinfectant','','images/menu/disinfectant-hover.gif',1) href='products.php?djnic=3&chem=0&prod=9'  ><img border='0' name=disinfectant onLoad=MM_preloadImages('images/menu/disinfectant-hover.gif') border=0 src=images/menu/disinfectant.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('toilet','','images/menu/toilet-hover.gif',1) href='products.php?djnic=3&chem=0&prod=10'  ><img border='0' name=toilet onLoad=MM_preloadImages('images/menu/toilet-hover.gif') border=0 src=images/menu/toilet.gif></a></td></tr>
<tr><td>
<a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('wax','','images/menu/wax-hover.gif',1) href='products.php?djnic=3&chem=0&prod=11'  ><img border='0' name=wax onLoad=MM_preloadImages('images/menu/wax-hover.gif') border=0 src=images/menu/wax.gif></a></td></tr>";}
?>
</td></tr></table>
 
 <!--comment php!--->
  <?php /*?><?php
 if($hint==2){
  echo "

 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Home','','images/home-hover.gif',1) href=index.php?djnic=1 ><img border='0' name=Home onLoad=MM_preloadImages('images/home-hover.gif') border=0 src=images/home.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Contact','','images/contact.gif',1) href=contact.php?djnic=2 ><img border='0' name=Contact onLoad=MM_preloadImages('images/contact.gif') border=0 src=images/contact-hover.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Products','','images/products-hover.gif',1) href=products.php?djnic=3><img border='0' name=Products onLoad=MM_preloadImages('images/products-hover.gif') border=0 src=images/products.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('services','','images/services-hover.gif',1) href=services.php?djnic=4 ><img border='0' name=services onLoad=MM_preloadImages('images/services-hover.gif') border=0 src=images/services.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('developers','','images/developers-hover.gif',1) href=developers.php?djnic=5 ><img border='0' name=developers onLoad=MM_preloadImages('images/developers-hover.gif') border=0 src=images/developers.gif></a>";
  }
  
   else   if($hint==3){
  echo "

 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Home','','images/home-hover.gif',1) href=index.php?djnic=1 ><img border='0' name=Home onLoad=MM_preloadImages('images/home-hover.gif') border=0 src=images/home.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Contact','','images/contact-hover.gif',1) href=contact.php?djnic=2 ><img border='0' name=Contact onLoad=MM_preloadImages('images/contact-hover.gif') border=0 src=images/contact.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Products','','images/products.gif',1) href=products.php?djnic=3><img border='0' name=Products onLoad=MM_preloadImages('images/products.gif') border=0 src=images/products-hover.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('services','','images/services-hover.gif',1) href=services.php?djnic=4 ><img border='0' name=services onLoad=MM_preloadImages('images/services-hover.gif') border=0 src=images/services.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('developers','','images/developers-hover.gif',1) href=developers.php?djnic=5 ><img border='0' name=developers onLoad=MM_preloadImages('images/developers-hover.gif') border=0 src=images/developers.gif></a>";
  }
     else   if($hint==4){
  echo "

 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Home','','images/home-hover.gif',1) href=index.php?djnic=1 ><img border='0' name=Home onLoad=MM_preloadImages('images/home-hover.gif') border=0 src=images/home.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Contact','','images/contact-hover.gif',1) href=contact.php?djnic=2 ><img border='0' name=Contact onLoad=MM_preloadImages('images/contact-hover.gif') border=0 src=images/contact.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Products','','images/products-hover.gif',1) href=products.php?djnic=3><img border='0' name=Products onLoad=MM_preloadImages('images/products-hover.gif') border=0 src=images/products.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('services','','images/services.gif',1) href=services.php?djnic=4 ><img border='0' name=services onLoad=MM_preloadImages('images/services.gif') border=0 src=images/services-hover.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('developers','','images/developers-hover.gif',1) href=developers.php?djnic=5 ><img border='0' name=developers onLoad=MM_preloadImages('images/developers-hover.gif') border=0 src=images/developers.gif></a>";
  }
       else   if($hint==5){
  echo "

 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Home','','images/home-hover.gif',1) href=index.php?djnic=1 ><img border='0' name=Home onLoad=MM_preloadImages('images/home-hover.gif') border=0 src=images/home.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Contact','','images/contact-hover.gif',1) href=contact.php?djnic=2 ><img border='0' name=Contact onLoad=MM_preloadImages('images/contact-hover.gif') border=0 src=images/contact.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Products','','images/products-hover.gif',1) href=products.php?djnic=3><img border='0' name=Products onLoad=MM_preloadImages('images/products-hover.gif') border=0 src=images/products.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('services','','images/services-hover.gif',1) href=services.php?djnic=4 ><img border='0' name=services onLoad=MM_preloadImages('images/services-hover.gif') border=0 src=images/services.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('developers','','images/developers.gif',1) href=developers.php?djnic=5 ><img border='0' name=developers onLoad=MM_preloadImages('images/developers.gif') border=0 src=images/developers-hover.gif></a>";
  }
  else {
  echo "

 <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Home','','images/home.gif',1) href=index.php?djnic=1 ><img border='0' name=Home onLoad=MM_preloadImages('images/home.gif') border=0 src=images/home-hover.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Contact','','images/contact-hover.gif',1) href=contact.php?djnic=2 ><img border='0' name=Contact onLoad=MM_preloadImages('images/contact-hover.gif') border=0 src=images/contact.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('Products','','images/products-hover.gif',1) href=products.php?djnic=3><img border='0' name=Products onLoad=MM_preloadImages('images/products-hover.gif') border=0 src=images/products.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('services','','images/services-hover.gif',1) href=services.php?djnic=4 ><img border='0' name=services onLoad=MM_preloadImages('images/services-hover.gif') border=0 src=images/services.gif></a>
  <a onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('developers','','images/developers-hover.gif',1) href=developers.php?djnic=5 ><img border='0' name=developers onLoad=MM_preloadImages('images/developers-hover.gif') border=0 src=images/developers.gif></a>";
  
  }
  ?>

<?php */?>