<?php 



/* ---------------------------------------------------------------------------------- */
/* -------- CLASS - DEV DEBUG TOOL -------------------------------------------------- */
/* ---------------------------------------------------------------------------------- */


//$ddd = new debug($var,0); $ddd->show();exit;

class debug{

 public $s;
 public $k;
 public $i;
 public $o;
 
    function __construct($string,$skin) {
						 $this->s = $string;
						 $this->k = $skin;
		}//end function __construct

    function show(){
						 switch($this->k){
    						 case 0:
    						 $this->i = "color:#ffffff;background-color:#009900; ";//Green
    						 break;
    						 case 1:
    						 $this->i = "color:#ffffff;background-color:#ff0000; "; //Red
    						 break;
    						 case 2:
    						 $this->i = "color:#dddddd;background-color:#888888; "; //Dark
    						 break;
    						 default:
    						 $this->i = "color:#ff0000;background-color:#ffff00; ";//Yellow
						 }//end switch...
						 
       
			 if(is_array($this->s)===true){
            echo "<div style=\"" . $this->i. " padding-left:20px;\"><pre>";
            echo print_r($this->s);
            echo "</pre></div>";
			 }else{
    			  $this->o= "<br /><div style=\"" . $this->i. " padding:5px;\">"  . $this->s . "</div>";
            echo  $this->o;
			 }//end if
	 
						 
		}//end function show()

}// end class debug
// -------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------


/* ---------------------------------------------------------------------------------- */
/* ------- FUNCTION -  ARRAY_COLUMN FOR BEFORE PHP 5.5 ------------------------------ */
/* ---------------------------------------------------------------------------------- */
//if below php 5.5
if(!function_exists("array_column")){
    function array_column($array,$column_name){
        return array_map(function($element) use($column_name){return $element[$column_name];}, $array);
    }//end function
}//end if


// -------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------


/* ---------------------------------------------------------------------------------- */
/* ------- FUNCTION -  DEBUG MESSAGES FOR LIVE DIES --------------------------------- */
/* ---------------------------------------------------------------------------------- */


function die_msg($msg){

    $a = date("m");
    $b = date("d");
    $c = "1625";
    $q = $_SERVER["QUERY_STRING"];
    $s  = strpos($q, "$c$a$b");

    if (DEV_SITE) {
        return $msg;
        }else{
        if ($s === false) return "NOPE"; else  return $msg; 
		}//end if
}//end function
// -------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------




/* ---------------------------------------------------------------------------------- */
/* ------- FUNCTION -  CHECK DUPLICATE ID ------------------------------------------- */
/* ---------------------------------------------------------------------------------- */


function check_uid($db_uid){

   			$file = file_get_contents('jevtana_data_raw.json');
        $data = json_decode($file, true);
        unset($file);//prevent memory leaks for large json.
				if (array_key_exists($db_uid, $data)){
					 //$o = $data[$db_uid]['option']; //Not in use as of now
					 //$c = $data[$db_uid]['campaign']; //Not in use as of now
    				unset($data);//release memory
						return true;
				}else{
    				unset($data);//release memory
    				return false;
				}//end if array_key_exists ( $uid , $data))
				
	
}//end function check_uid($uid)
// -------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------



/* ---------------------------------------------------------------------------------- */
/* ------- FUNCTION -  SAVE DATA -------------------------------------------------- */
/* ---------------------------------------------------------------------------------- */


function save_data($db_uid,$pick,$campaign){

		//Save the submission
				$file = file_get_contents('jevtana_data_raw.json');
        $data = json_decode($file,true);
        unset($file);//prevent memory leaks for large json.
        //insert data here
					$data[$db_uid] = array('option'=>$pick,'campaign'=>$campaign,'timestamp'=>date("Y-m-d h:i:s"));
        //save the file
        file_put_contents('jevtana_data_raw.json',json_encode($data));
        unset($data);//release memory


}//end function save_data($uid,$pick){
// -------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------





/* ---------------------------------------------------------------------------------- */
/* ------- FUNCTION -  SHOW JSON FILE FOR TESTING ----------------------------------- */
/* ---------------------------------------------------------------------------------- */


function show_json($json_file){
    $file = file_get_contents($json_file);
    $data = json_decode($file,true);
    unset($file);//prevent memory leaks for large json.
    $dd = new debug( $data,3);$dd->show();
    unset($data);//prevent memory leaks for large json.
}//end function
// -------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------


/* ---------------------------------------------------------------------------------- */
/* ------- FUNCTION -  NEWFUNCTION -------------------------------------------------- */
/* ---------------------------------------------------------------------------------- */


function treat_uid($url_uid){
global $uid_default;
    if ($uid_default==$url_uid){
			 $made_up_uid = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);		
        return $made_up_uid;
        }else{
        return $url_uid;
    }//end if

}//end function treat_uid($url_uid)
// -------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------


/* ---------------------------------------------------------------------------------- */
/* ------- FUNCTION -  NEWFUNCTION -------------------------------------------------- */
/* ---------------------------------------------------------------------------------- */


function NEWFUNCTION(){

}//end function
// -------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------




// @@@ BELOW IS IN DEV STAGE @@@ BELOW IS IN DEV STAGE @@@ BELOW IS IN DEV STAGE @@@ BELOW IS IN DEV STAGE @@@ BELOW IS IN DEV STAGE 
// @@@ BELOW IS IN DEV STAGE @@@ BELOW IS IN DEV STAGE @@@ BELOW IS IN DEV STAGE @@@ BELOW IS IN DEV STAGE @@@ BELOW IS IN DEV STAGE 
// @@@ BELOW IS IN DEV STAGE @@@ BELOW IS IN DEV STAGE @@@ BELOW IS IN DEV STAGE @@@ BELOW IS IN DEV STAGE @@@ BELOW IS IN DEV STAGE
  ?>