

<?php 
// ---------------------------------------------
// ---------- Global RegExp Patterns -----------
// ---------------------------------------------

/* * used in all validations by php or javascript cross site * */

$numeric_pattern = '/^[\d]{1,15}$/';
$numeric_validation_hint = 'numbers only';

$opentext_pattern = '/^(.){5,2000}$/m';
$opentext_validation_hint = '2000 characters maximum';

$limitedtext_pattern = '/^[A-Za-z\s_]{3,}$/'; //officially letters only, the underscore is authorized for form values to be validated
$limitedtext_validation_hint = '3 characters minimum, letters only';

$password_pattern = '/^[A-Za-z\d]{8,16}$/';
$password_validation_hint = '8 to 16 characters , digits & letters only';

$zipcode_pattern = '/^[\d]{5}$|^[\d]{5}-[\d]{4}$/';
$zipcode_validation_hint= 'Must be in format xxxxx or xxxxx-xxxx, digits only';

$phonenumber_pattern = '/^[\d]{3,}-[\d]{3,}-[\d]{4,}$/';
$phonenumber_validation_hint= 'Must be in the format xxx-xxx-xxxx';

$email_pattern = '/^[A-Z0-9](\.?[A-Z0-9-_])+@[A-Z0-9](\.?[A-Z0-9-])*\.[A-Z]{2,4}$/i';
$email_validation_hint= 'Must be in the format name@domain.com';

 
// ---------------------------------------------
// ---------- IIF Inline Condition -------------
// ---------------------------------------------

function iif($condition, $option1, $option2){
	if ($condition)
		return $option1;
	Else
		return $option2;

}// end function
// -------------------------------------------------------------------------------------------

// ---------------------------------------------
// ---------- Ready Data For SQL (MySql) -------
// ---------------------------------------------

function sql_ready($the_data, $the_type){
	switch ($the_type){
		   case 0:
		   // INT
		   return  mysql_real_escape_string($the_data);
		   break;
		   case 1:
		   // VARCHAR
		   return "'" . mysql_real_escape_string($the_data) . "'";
		   break;
		   case 2:
		   // DATETIME
		   return "'" . mysql_real_escape_string($the_data) . "'";
		   break;
		   }

}// end function
// ---------------	----------------------------------------------------------------------------


// ---------------------------------------------
// ---------- Data Validation ---------- -------
// ---------------------------------------------

function validate_data($the_pattern,$the_value,$is_required){

global $numeric_pattern, $numeric_validation_hint;
global $opentext_pattern, $opentext_validation_hint;
global $limitedtext_pattern, $limitedtext_validation_hint;
global $password_pattern, $password_validation_hint;
global $zipcode_pattern, $zipcode_validation_hint;
global $phonenumber_pattern, $phonenumber_validation_hint;
global $email_pattern, $email_validation_hint;
      
		  
    switch($the_pattern)
    {
    case 'numeric':
  		$the_regexp = $numeric_pattern;
  		$msg_error= $numeric_validation_hint;
      break;
    case 'opentext':
  		$the_regexp = $opentext_pattern;
  		$msg_error= $opentext_validation_hint;
      break;
    case 'limitedtext':
  		$the_regexp = $limitedtext_pattern;
  		$msg_error= $limitedtext_validation_hint;
      break;
    case 'password':
  		$the_regexp = $password_pattern;
  		$msg_error= $password_validation_hint;
      break;
    case 'zipcode':
			$the_regexp = $zipcode_pattern;
  		$msg_error= $zipcode_validation_hint;
      break;
    case 'phonenumber':
			$the_regexp = $phonenumber_pattern;
  		$msg_error= $phonenumber_validation_hint;
      break;
    case 'email':
			$the_regexp = $email_pattern;
  		$msg_error= $email_validation_hint;
      break;
    }



$has_error=false;
if ($the_value !=''){

    $has_error = !preg_match ($the_regexp,$the_value);
		}
		else
		{
		if ($is_required==1) $has_error=true;
		}

		return array($has_error,$msg_error); 


}// end function
// -------------------------------------------------------------------------------------------


// ---------------------------------------------
// ---------- Contextual Data Fetcher ----------
// ---------------------------------------------

function get_textual_data($the_index,$the_type){

switch ($the_type){
  case 'test_status':
    switch ($the_index){
      case 0:
		  $textual_data = "Never Activated"; 
      break;
      case 1:
		  $textual_data = "Active" ;
      break;
      case 2:
		  $textual_data = "On Hold" ;
      break;
      case 3:
		  $textual_data = "Expired - Not Enough Credit"; 
      break;
    }//end switch $the_index
  break;
  case 'test_status_action':
    switch ($the_index){
      case 0:
		  $textual_data = "Activate"; 
      break;
      case 1:
		  $textual_data = "Put On Hold" ;
      break;
      case 2:
		  $textual_data = "Activate" ;
      break;
      case 3:
		  $textual_data = "Purchase Credit"; 
      break;
    }//end switch $the_index
  break;
  case 'app_info':
    switch ($the_index){
      case '':
		  $textual_data = "NO"; 
      break;
      case 'requested':
		  $textual_data = "YES";
      break;
      case (strpos($the_index,'_embed')!=false):
		  $textual_data = "Embeded" ;
      break;
      case (strpos($the_index,'_attach')!=false):
		  $textual_data = "As Attachment" ;
      break;
	  }//end switch $the_index
  break;
}//end switch $the_type

return $textual_data;
}// end function
// -------------------------------------------------------------------------------------------


// ---------------------------------------------
// ---------- Contextual CSS Fetcher -----------
// ---------------------------------------------

function get_context_css($the_index,$the_type){

switch ($the_type){
  case 'test_status':
    switch ($the_index){
      case 0:
		  $context_css = "textfont2";
      break;
      case 1:
		  $context_css = "textfont3" ;
      break;
      case 2:
		  $context_css = "textfont4" ;
      break;
      case 3:
		  $context_css = "textfont2" ;
      break;
    }//end switch $the_index
  break;
  case 'test_status_action':
    switch ($the_index){
      case 0:
		  $context_css = "textfont3";
      break;
      case 1:
		  $context_css = "textfont4" ;
      break;
      case 2:
		  $context_css = "textfont3" ;
      break;
      case 3:
		  $context_css = "textfont3" ;
      break;
    }//end switch $the_index
  break;
  case 'app_info':
    switch ($the_index){
      case '':
		  $context_css = "textfont2";
      break;
      case 'requested':
		  $context_css = "textfont3" ;
      break;
      case (strpos($the_index,'_embed')!=false):
		  $context_css = "textfont3" ;
      break;
      case (strpos($the_index,'_attach')!=false):
		  $context_css = "textfont3" ;
      break;
    }//end switch $the_index
  break;
}//end switch $the_type

return $context_css;
}// end function
// -------------------------------------------------------------------------------------------


// ---------------------------------------------
// ---------- debugger message ---------- -------
// ---------------------------------------------

function echo_dev($the_string){

$the_output= "<br/><span style=\"color:#ff0000;background-color:#ffff00;padding-left:20px;\">";
$the_output .= "DEBUG in :: ";
$the_output .= "$the_string &nbsp;&nbsp;&nbsp;&nbsp;</span><br/>";

echo $the_output;

}// end function
// -------------------------------------------------------------------------------------------

// ---------------------------------------------
// ---------- ABBREVIATE TEXT STRING -----------
// ---------------------------------------------

function abbreviate_text($the_string,$the_length){

    if (strlen($the_string)>$the_length)
			return substr($the_string,0,$the_length) . "...";
		else
			return $the_string;
}// end function
// -------------------------------------------------------------------------------------------


// ---------------------------------------------
// ---------- CUTE CYPHER  ---------------------
// ---------------------------------------------

function cute_cypher($the_plaintext){
  $the_salt = 5; //1 to 5 
  $shuffle_string="abcdefghijklmnopqrstuvwxyz1234567890";
  $shuffle_string .= strtoupper($shuffle_string);
  for ($k=1;$k<5;$k++){$shuffle_string .= $shuffle_string;}
  $shuffle_string = str_shuffle($shuffle_string);

  $the_cute_cypher='';
  for ($c=0;$c<strlen($the_plaintext);$c++){$the_cute_cypher .= substr($shuffle_string,$c*$the_salt,$the_salt).substr($the_plaintext,$c,1);}
	$the_cute_cypher .= substr($shuffle_string,$c*$the_salt,$the_salt);
  
	return $the_cute_cypher;
}// end function
// -------------------------------------------------------------------------------------------



function cute_decypher($the_cute_cypher){
  $the_salt = 5;
	$the_decyphered='';
  for ($c=$the_salt;$c<strlen($the_cute_cypher);$c+=$the_salt+1){$the_decyphered .= substr($the_cute_cypher,$c,1);}
	return $the_decyphered;

}// end function
// -------------------------------------------------------------------------------------------



// ---------------------------------------------
// -- TIME ELAPSED BETWEEN TWO DATES -----------
// ---------------------------------------------
// $date_start,$date_end are integers representing a number of seconds.
// returns an integer - fractions of time intervals are ignored
function elapsed_time($date_start,$date_end,$interval_type) 
    { 
    $interval_length["year"]=60*60*24*365.25; // not thoroughly tested
    $interval_length["month"]=60*60*24*365.25/12; // not thoroughly tested
    $interval_length["week"]=60*60*24*7; 
    $interval_length["day"]=60*60*24; 
    $interval_length["hour"]=60*60; 
    $interval_length["minute"]=60; 
    $interval_length["second"]=1;
		 
    $elapsed_time = abs($date_end-$date_start); 
    $elapsed_time = floor($elapsed_time/$interval_length[$interval_type]); 
    return $elapsed_time; 

}// end function
// -------------------------------------------------------------------------------------------


// --------------------------------------------------------------------------
// -- ESTIMATES HEIGHT OF THE BOX ACCORDINGLY TO ITS TEXT CONTENT -----------
// --------------------------------------------------------------------------
// $the_width & $the_fontsize in px;
function fudge_height($the_text,$the_width,$the_fontsize){
    $font_width[12]=7.06;
    $font_height[12]=15;
    
    $t=explode("\n",$the_text);
    $lb = count($t);
    for ($s=0;$s<count($t);$s++){
    		$lb += ceil(0.0001+strlen($t[$s])*$font_width[$the_fontsize]/$the_width);
    }//end for ($s=0;$s<=$lb;$s++)
    
    return $lb*$font_height[$the_fontsize];

}// end function
// -------------------------------------------------------------------------------------------



?>


<script type = "text/javascript">
<!--

<?php 
echo "// ---------- Global RegExp Patterns ---------------------------------------------------------\n\n";

echo "var numeric_pattern =" . $numeric_pattern .";\n";
echo "var numeric_validation_hint =" ."'" .  $numeric_validation_hint . "';\n";

echo "var opentext_pattern =" . $opentext_pattern .";\n";
echo "var opentext_validation_hint =" ."'" .  $opentext_validation_hint . "';\n";

echo "var limitedtext_pattern =" . $limitedtext_pattern . ";\n";
echo "var limitedtext_validation_hint = " ."'" .  $limitedtext_validation_hint . "';\n";

echo "var password_pattern = " .$password_pattern . ";\n";
echo "var password_validation_hint = " ."'" .  $password_validation_hint . "';\n";

echo "var zipcode_pattern = " .$zipcode_pattern . ";\n";
echo "var zipcode_validation_hint= " ."'" .  $zipcode_validation_hint . "';\n";

echo "var phonenumber_pattern = " .$phonenumber_pattern .";\n";
echo "var phonenumber_validation_hint= " ."'" .  $phonenumber_validation_hint . "';\n";

echo "var email_pattern = " .$email_pattern .";\n";
echo "var email_validation_hint= " ."'" .  $email_validation_hint . "';\n";

 ?>
 
// -->
</script>
