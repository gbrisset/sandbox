<?php
class ams_utilities {

function __construct($p){

    $this->ams_pdo = $p;

    // Validation patterns ---------------------
    $this->data_validation['article_title'] = array('regex' => "/^[A-Za-z\d\s\"\'\*\#\&\%\(\)\!\?\.\,\:\;]{10,1000}$/i", 'error_msg' => "Must be 10 chars minimum - Authorized special characters: !.? , : ; \" ' & # % () " );
    $this->data_validation['simple_text'] = array('regex' => "/^[A-Za-z\d\s]{1,}$/i", 'error_msg' => "Please no special characters." );
    $this->data_validation['numeric'] = array('regex' => "/^[\d]{1,}$/", 'error_msg' => "Digit only");
    $this->data_validation['email'] = array('regex' => "/^[A-Z0-9](\.?[A-Z0-9-'_])+@[A-Z0-9](\.?[A-Z0-9-])*\.[A-Z]{2,4}$/i", 'error_msg' => "Must be in the format name@domain.com");
    // $this->data_validation['xxxxxxxxxxx'] array('regex' => "zzzzzzzzz", 'error_msg' => "";
    // $this->data_validation['xxxxxxxxxxx'] array('regex' => "zzzzzzzzz", 'error_msg' => "";


}//end function


/* ************************************************************************************************************************************************* */
/* ********   DEBUGGING   ************************************************************************************************************************** */
/* ************************************************************************************************************************************************* */

// $ams_utilities->better_vardump('',3);// 0- green; 1-red; 2-grey; 3-yellow   

    function better_vardump($s,$k=3) {
         $s; // string, object to output
         $k; // skin
         $i; // insert (style)
         $o; // output
             switch($k){
                 case 0:
                 $this->i = "color:#ffffff;background-color:#007700; ";//Green
                 break;
                 case 1:
                 $this->i = "color:#ffffff;background-color:#880000; "; //Red
                 break;
                 case 2:
                 $this->i = "color:#dddddd;background-color:#888888; "; //Dark
                 break;
                 default:
                 $this->i = "color:#ff0000;background-color:#ffff00; ";//Yellow
             }//end switch...
                         
       
            if(is_array($s)){
                echo "<div style=\"" . $this->i. " padding-left:10px;\">ams_DEBUG :: ".date("Y-m-d h:i:s") . " :: <pre>";
                echo print_r($s);
                echo "</pre></div>";

            }elseif(is_object($s)){
                echo "<div style=\"" . $this->i. " padding-left:10px;\">ams_DEBUG :: ".date("Y-m-d h:i:s") . " :: <pre>";
                var_dump($s);
                echo "</pre></div>";
             }else{
                $this->o= "<br /><div style=\"" . $this->i. " padding:25px;\">ams_DEBUG :: ".date("Y-m-d h:i:s") . " :: " . $s . "</div><br />";
                echo  $this->o;
             }//end if
     
                         
        }//end function better_vardump()
// -------------------------------------------------------------------------------------------

/* ************************************************************************************************************************************************* */
/* ********   VALIDATION   ************************************************************************************************************************* */
/* ************************************************************************************************************************************************* */

function validate_data($data_type, $data_to_validate, $max_length=10000, $is_required=0){



    // processing ---------------------
    $regex = $this->data_validation[$data_type]['regex'];
    $is_valid=false;

    if ($data_to_validate ==''){
            if ($is_required==false) $is_valid=true;
        }else{
            $is_valid = preg_match ($regex,$data_to_validate);
    }//if ($data_to_validate =='')

    $error_msg = ($is_valid)? "" : $this->data_validation[$data_type]['error_msg'];
    
    return array($is_valid,$error_msg); 

}//end function validate_data(...)



/* ************************************************************************************************************************************************* */
/* ********   DATABASE   *************************************************************************************************************************** */
/* ************************************************************************************************************************************************* */

function sql_get_one_row($query, $params=[], $fetch_type=PDO::FETCH_ASSOC){

// $fetch_type can be
    // PDO::FETCH_NUM returns enumerated array
    // PDO::FETCH_ASSOC returns associative array
    // PDO::FETCH_BOTH - both of the above
    // PDO::FETCH_OBJ returns object
    // PDO::FETCH_LAZY allows all three (numeric associative and object) methods without memory overhead.

  $stmt = $this->ams_pdo->prepare($query);
  $stmt->execute($params);
  $onerow = $stmt->fetch($fetch_type);// or die('#SQL:QW876DG6789SDB43');
  return $onerow;

}//end function get_one_row
// -------------------------------------------------------------------------------------------


function sql_get_all_rows($query, $params=[], $fetch_type=PDO::FETCH_ASSOC){

// extra fetch_types
    // PDO::FETCH_COLUMN
    // PDO::FETCH_KEY_PAIR
    // PDO::FETCH_UNIQUE
    // PDO::FETCH_GROUP

  $stmt = $this->ams_pdo->prepare($query);
  $stmt->execute($params);
  $allrows = $stmt->fetchAll($fetch_type) ; 
  return $allrows;

}//end function get_all_rows
// -------------------------------------------------------------------------------------------

function sql_execute($query, $params=[]){
 
 // DML queries: INSERT, UPDATE, or DELETE
  $stmt = $this->ams_pdo->prepare($query);
  $stmt->execute($params) or die('#SQL:4E74DEJ5DDF8SG4D55E7E');
  $rowcount = $stmt->rowCount();
  return $rowcount;

}//end function 
// -------------------------------------------------------------------------------------------


/* ************************************************************************************************************************************************* */
/* ********   SECURITY   *************************************************************************************************************************** */
/* ************************************************************************************************************************************************* */

    function isPasswordStrongEnough($password){
                 
        if (strlen($password) < 10) {return false; }else  {return true;}
                 
    }//end function isPasswordStrongEnough($password)


// CRSF protection
// ***************************************************************************
// simply insert $ams_utilities->ams_csrf_field() inside a <form></form>
// then check the request ($_POST/$_GET) with ams_csrf_check($request_data)
// the principle is simple: any not legit request is redirected away from the site
// ***************************************************************************

    function ams_csrf_field(){

        $ams_csrf_hash = hash('sha256', $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time());
        $_SESSION['ams_csrf'] = $ams_csrf_hash;
        $ams_csrf_html = "<input type=\"hidden\" id=\"ams_csrf\" name=\"ams_csrf\" value=\"$ams_csrf_hash\">";
        echo($ams_csrf_html);

    }//end function ams_csrf_field()


    function ams_csrf_check($request_data){

        $ams_csrf_hash_request = (isset($request_data['ams_csrf']))? $request_data['ams_csrf'] : "Request Data CSRF not set" ;
        $ams_csrf_hash_session = (isset($_SESSION['ams_csrf']))? $_SESSION['ams_csrf'] : "Session CSRF not set" ;

        if ($ams_csrf_hash_request==$ams_csrf_hash_session) {
            return true;
        }else{
            header("Location: https://www.fbi.gov/investigate/cyber" );
        }//end if
                 
    }//end function ams_csrf_check($request_data)


/* ************************************************************************************************************************************************* */
/* ********   OTHER   ****************************************************************************************************************************** */
/* ************************************************************************************************************************************************* */

function readFromFile($the_filename){
    $fh = fopen($the_filename, 'r') or die("Can't open $the_filename");
    $the_data = fread($fh, filesize($the_filename));
    fclose($fh);
    return $the_data;
}// end function
// -------------------------------------------------------------------------------------------


function is_mobile(){

// found on https://stackoverflow.com/questions/4117555/simplest-way-to-detect-a-mobile-device
$uaFull = strtolower($_SERVER['HTTP_USER_AGENT']);
$uaStart = substr($uaFull, 0, 4);

$uaPhone = [ // use `= array(` if PHP<5.4
    '(android|bb\d+|meego).+mobile',
    'avantgo',
    'bada\/',
    'blackberry',
    'blazer',
    'compal',
    'elaine',
    'fennec',
    'hiptop',
    'iemobile',
    'ip(hone|od)',
    'iris',
    'kindle',
    'lge ',
    'maemo',
    'midp',
    'mmp',
    'mobile.+firefox',
    'netfront',
    'opera m(ob|in)i',
    'palm( os)?',
    'phone',
    'p(ixi|re)\/',
    'plucker',
    'pocket',
    'psp',
    'series(4|6)0',
    'symbian',
    'treo',
    'up\.(browser|link)',
    'vodafone',
    'wap',
    'windows ce',
    'xda',
    'xiino'
]; // use `);` if PHP<5.4

$uaMobile = [ // use `= array(` if PHP<5.4
    '1207', 
    '6310', 
    '6590', 
    '3gso', 
    '4thp', 
    '50[1-6]i', 
    '770s', 
    '802s', 
    'a wa', 
    'abac|ac(er|oo|s\-)', 
    'ai(ko|rn)', 
    'al(av|ca|co)', 
    'amoi', 
    'an(ex|ny|yw)', 
    'aptu', 
    'ar(ch|go)', 
    'as(te|us)', 
    'attw', 
    'au(di|\-m|r |s )', 
    'avan', 
    'be(ck|ll|nq)', 
    'bi(lb|rd)', 
    'bl(ac|az)', 
    'br(e|v)w', 
    'bumb', 
    'bw\-(n|u)', 
    'c55\/', 
    'capi', 
    'ccwa', 
    'cdm\-', 
    'cell', 
    'chtm', 
    'cldc', 
    'cmd\-', 
    'co(mp|nd)', 
    'craw', 
    'da(it|ll|ng)', 
    'dbte', 
    'dc\-s', 
    'devi', 
    'dica', 
    'dmob', 
    'do(c|p)o', 
    'ds(12|\-d)', 
    'el(49|ai)', 
    'em(l2|ul)', 
    'er(ic|k0)', 
    'esl8', 
    'ez([4-7]0|os|wa|ze)', 
    'fetc', 
    'fly(\-|_)', 
    'g1 u', 
    'g560', 
    'gene', 
    'gf\-5', 
    'g\-mo', 
    'go(\.w|od)', 
    'gr(ad|un)', 
    'haie', 
    'hcit', 
    'hd\-(m|p|t)', 
    'hei\-', 
    'hi(pt|ta)', 
    'hp( i|ip)', 
    'hs\-c', 
    'ht(c(\-| |_|a|g|p|s|t)|tp)', 
    'hu(aw|tc)', 
    'i\-(20|go|ma)', 
    'i230', 
    'iac( |\-|\/)', 
    'ibro', 
    'idea', 
    'ig01', 
    'ikom', 
    'im1k', 
    'inno', 
    'ipaq', 
    'iris', 
    'ja(t|v)a', 
    'jbro', 
    'jemu', 
    'jigs', 
    'kddi', 
    'keji', 
    'kgt( |\/)', 
    'klon', 
    'kpt ', 
    'kwc\-', 
    'kyo(c|k)', 
    'le(no|xi)', 
    'lg( g|\/(k|l|u)|50|54|\-[a-w])', 
    'libw', 
    'lynx', 
    'm1\-w', 
    'm3ga', 
    'm50\/', 
    'ma(te|ui|xo)', 
    'mc(01|21|ca)', 
    'm\-cr', 
    'me(rc|ri)', 
    'mi(o8|oa|ts)', 
    'mmef', 
    'mo(01|02|bi|de|do|t(\-| |o|v)|zz)', 
    'mt(50|p1|v )', 
    'mwbp', 
    'mywa', 
    'n10[0-2]', 
    'n20[2-3]', 
    'n30(0|2)', 
    'n50(0|2|5)', 
    'n7(0(0|1)|10)', 
    'ne((c|m)\-|on|tf|wf|wg|wt)', 
    'nok(6|i)', 
    'nzph', 
    'o2im', 
    'op(ti|wv)', 
    'oran', 
    'owg1', 
    'p800', 
    'pan(a|d|t)', 
    'pdxg', 
    'pg(13|\-([1-8]|c))', 
    'phil', 
    'pire', 
    'pl(ay|uc)', 
    'pn\-2', 
    'po(ck|rt|se)', 
    'prox', 
    'psio', 
    'pt\-g', 
    'qa\-a', 
    'qc(07|12|21|32|60|\-[2-7]|i\-)', 
    'qtek', 
    'r380', 
    'r600', 
    'raks', 
    'rim9', 
    'ro(ve|zo)', 
    's55\/', 
    'sa(ge|ma|mm|ms|ny|va)', 
    'sc(01|h\-|oo|p\-)', 
    'sdk\/', 
    'se(c(\-|0|1)|47|mc|nd|ri)', 
    'sgh\-', 
    'shar', 
    'sie(\-|m)', 
    'sk\-0', 
    'sl(45|id)', 
    'sm(al|ar|b3|it|t5)', 
    'so(ft|ny)', 
    'sp(01|h\-|v\-|v )', 
    'sy(01|mb)', 
    't2(18|50)', 
    't6(00|10|18)', 
    'ta(gt|lk)', 
    'tcl\-', 
    'tdg\-', 
    'tel(i|m)', 
    'tim\-', 
    't\-mo', 
    'to(pl|sh)', 
    'ts(70|m\-|m3|m5)', 
    'tx\-9', 
    'up(\.b|g1|si)', 
    'utst', 
    'v400', 
    'v750', 
    'veri', 
    'vi(rg|te)', 
    'vk(40|5[0-3]|\-v)', 
    'vm40', 
    'voda', 
    'vulc', 
    'vx(52|53|60|61|70|80|81|83|85|98)', 
    'w3c(\-| )', 
    'webc', 
    'whit', 
    'wi(g |nc|nw)', 
    'wmlb', 
    'wonu', 
    'x700', 
    'yas\-', 
    'your', 
    'zeto', 
    'zte\-'
]; // use `);` if PHP<5.4

		$isPhone = preg_match('/' . implode($uaPhone, '|') . '/i', $uaFull);
		$isMobile = preg_match('/' . implode($uaMobile, '|') . '/i', $uaStart);

		if($isPhone || $isMobile) {
		    return true;
		} else {
		    return false;
		}//end if

}//end function is_mobile()
// -------------------------------------------------------------------------------------------



}//end class

?>