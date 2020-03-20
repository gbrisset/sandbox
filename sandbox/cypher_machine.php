<?php 

//include 'zx_functions.php';


$the_number = 1000;
$the_number = " '' or =1=1;:";

for ($i=1;$i<10;$i++){

$the_cute_cypher=cute_cypher($the_number);

$the_decyphered=cute_decypher($the_cute_cypher);

echo $the_number  . " <b>becomes :</b> " . $the_cute_cypher ."<b> then is returned as : </b>" . $the_decyphered  . "<b> say one if they match </b>" .($the_number==$the_decyphered)."<br/>";

echo strlen($the_number)  . " <b>becomes :</b> " . strlen($the_cute_cypher)."<br/>";

//$the_number += 145;
$the_number .= " q";
}




function cute_cypher($the_plaintext){
  $the_salt = 5; //1 to 5 
  $shuffle_string="abcdefghijklmnopqrstuvwxyz1234567890";
  $shuffle_string .= strtoupper($shuffle_string);
  for ($k=1;$k<5;$k++){$shuffle_string .= $shuffle_string;}
  $shuffle_string = str_shuffle($shuffle_string);

  $the_cute_cypher='';
  for ($c=0;$c<strlen($the_plaintext);$c++){
	
	
//	echo substr($shuffle_string,$c*$the_salt,$the_salt). " - " .substr($the_plaintext,$c,1). " <br/> ";
	
	$the_cute_cypher .= substr($shuffle_string,$c*$the_salt,$the_salt).substr($the_plaintext,$c,1);
	}
	$the_cute_cypher .= substr($shuffle_string,$c*$the_salt,$the_salt);
  
	return $the_cute_cypher;
}// end function
// -------------------------------------------------------------------------------------------



function cute_decypher($the_cute_cypher){
  $the_salt = 5;
	$the_decyphered='';
	
  for ($c=$the_salt;$c<strlen($the_cute_cypher);$c+=$the_salt+1)
	{
	//echo substr($the_cute_cypher,$c,1). " <br/> ";
	$the_decyphered .= substr($the_cute_cypher,$c,1);
	}


	return $the_decyphered;

}// end function
// -------------------------------------------------------------------------------------------



function real_cypher($input){
 /* Open the cipher */
    $td = mcrypt_module_open('rijndael-256', '', 'cfb', '');

    /* Create the IV and determine the keysize length, use MCRYPT_RAND
     * on Windows instead */
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td),  MCRYPT_RAND);
    $ks = mcrypt_enc_get_key_size($td);

    /* Create key */
    $key = substr(md5('very secret key'), 0, $ks);

    /* Intialize encryption */
    mcrypt_generic_init($td, $key, $iv);

    /* Encrypt data */
    $encrypted = mcrypt_generic($td, $input);


    /* Terminate encryption handler */
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
  
	return $encrypted;
}

function real_decypher($encrypted){
 /* Open the cipher */
    $td = mcrypt_module_open('rijndael-256', '', 'cfb', '');

    /* Create the IV and determine the keysize length, use MCRYPT_RAND
     * on Windows instead */
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td),  MCRYPT_RAND);
    $ks = mcrypt_enc_get_key_size($td);

    /* Create key */
    $key = substr(md5('very secret key'), 0, $ks);

    /* Initialize encryption module for decryption */
    mcrypt_generic_init($td, $key, $iv);

    /* Decrypt encrypted string */
    $decrypted_data = mdecrypt_generic($td, $encrypted);

    /* Terminate decryption handle and close module */
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
  
	return $decrypted_data ;
}

?>



