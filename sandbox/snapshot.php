<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<meta http-equiv="refresh" content="60;">
	<title>sandbox</title>

</head>

<body >


<?php 

include 'zx_functions.php';





echo "last refresh at " .date("H - i - s");
?>

<br />
<br />
<br />



<br />
<br />
<br />

<?php 

echo elapsed_time(strtotime(date("Y-m-d")),strtotime("2009-10-06"),"day"); 


?> 


</body></html>