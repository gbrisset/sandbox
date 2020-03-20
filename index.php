
<h1>SANBOX FILE</h1>

<?php
$azerty = "AZERTY";
echo '<br/>qwerty and $azerty';
echo '<br/>qwerty and $azerty';
echo "<br/>qwerty and {$azerty}QWERTY";
echo "<br/>";
// --------------------------------------------------------------------------
// -- SANDBOX FILE TO PLAY WITH ---------------------------------------------
// --------------------------------------------------------------------------

echo dirname( __FILE__ ) ;
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
,'PATH'
,'SystemRoot'
,'COMSPEC'
,'PATHEXT'
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

print_r2($server);


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
