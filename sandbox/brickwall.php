<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<meta http-equiv="refresh" content="60;">
	<title>sandbox</title>

	
	<style type = "text/css">
<!-- 
td.redbrick_long{
border: solid 4px;
border-color: #ff6666 #ff6666 #300000 #300000;
background-color: #880000;
width:100px;
height:50px;}

td.redbrick_short{
border: solid 4px;
border-color: #ff6666 #ff6666 #300000 #300000;
background-color: #880000;
max-width:50px;
height:50px;}


 
-->
</style>
	
</head>

<body style="margin:0px;background-color:#00ff00;" >


<table align="center" cellpadding="0" cellspacing="0">

<?php for ($a=0;$a<10;$a++){?>

<tr>
<td class="redbrick_short" >&nbsp;</td>
<?php for ($b=0;$b<6;$b++){?>
<td class="redbrick_long" colspan="3" >&nbsp;</td>
<?php } //end for ($b=0;$b<10;$b++){?>

</tr>

<tr>


<?php for ($b=0;$b<6;$b++){?>
<td class="redbrick_long" colspan="2" >&nbsp;</td>
<?php } //end for ($b=0;$b<10;$b++){?>
<td class="redbrick_short" >&nbsp;</td>

</tr>




<?php 
}// end for ($a=0;$a<10;$a++)
?> 


</table>
</body></html>