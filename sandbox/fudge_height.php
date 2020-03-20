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

<?php 
$the_text = "LINE 1 min\n";
$the_text .= "LINE 2 mi";

echo "<div style='background-color:#ccc;width:600px;height:". fudge_height($the_text,600,12) ."px;'>";
echo nl2br($the_text);
echo "</div>";
?> 


</body></html>