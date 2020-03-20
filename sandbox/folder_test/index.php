
<h1>SANBOX FILE</h1>

<?php


// --------------------------------------------------------------------------
// -- SANDBOX FILE TO PLAY WITH ---------------------------------------------
// --------------------------------------------------------------------------

echo "<br />1. ". dirname( __FILE__ ) ;

echo "<br />2. ".  __DIR__  ;

$current_directory = substr(pathinfo($_SERVER['SCRIPT_NAME'],PATHINFO_DIRNAME),1); //to insert path name 
echo "<br />3. $current_directory";


/*
$server = array(
'HTTP_HOST'
'HTTP_CONNECTION'
'HTTP_UPGRADE_INSECURE_REQUESTS'
'HTTP_USER_AGENT'
'HTTP_ACCEPT'
'HTTP_ACCEPT_ENCODING'
'HTTP_ACCEPT_LANGUAGE'
'PATH'
'SystemRoot'
'COMSPEC'
'PATHEXT'
'WINDIR'
'SERVER_SOFTWARE'
'SERVER_NAME'
'SERVER_ADDR'
'SERVER_PORT'
'REMOTE_ADDR'
'DOCUMENT_ROOT'
'REQUEST_SCHEME'
'CONTEXT_PREFIX'
'CONTEXT_DOCUMENT_ROOT'
'SERVER_ADMIN'
'SCRIPT_FILENAME'
'REMOTE_PORT'
'GATEWAY_INTERFACE'
'SERVER_PROTOCOL'
'REQUEST_METHOD'
'QUERY_STRING'
'REQUEST_URI'
'SCRIPT_NAME'
'PHP_SELF'
'REQUEST_TIME_FLOAT'
'REQUEST_TIME'
)*/

$server = array(
'HTTP_HOST'
,'HTTP_USER_AGENT'
,'SystemRoot'
,'DOCUMENT_ROOT'
,'REQUEST_SCHEME'
,'CONTEXT_PREFIX'
,'CONTEXT_DOCUMENT_ROOT'
,'SCRIPT_FILENAME'
,'SERVER_PROTOCOL'
,'QUERY_STRING'
,'REQUEST_URI'
,'SCRIPT_NAME'
,'PHP_SELF'
);


$format = "<br />my display of SERVER[%s] = %s ";
foreach ($server as $k => $v){

echo sprintf($format, $v, $_SERVER[$v]);

}//end foreachv



/*

$num = 5;
$location = 'tree';

$format = 'There are %d monkeys in the %s';
echo sprintf($format, $num, $location);

*/



// --------------------------------------------------------------------------
// -- VARIABLE PRINTING - DEBUG ---------------------------------------------
// --------------------------------------------------------------------------

function print_r2($val){
        echo '<pre>';
        print_r($val);
        echo  '</pre>';
}// end function



print_r2($_SERVER);



?>
