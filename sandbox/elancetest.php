<?php 




$list = "200";

for ($x=201;$x<601;$x++){

if ($x%8==0)$list .= ",".$x;


}//end for

echo $list;

 ?>