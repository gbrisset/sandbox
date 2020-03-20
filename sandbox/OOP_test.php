<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title>OOP coding</title>

</head>

<body >


<?php 

include 'zx_functions.php';



class calculator
{
    // property declaration
    public $number1;
    public $number2;
		
    // method declaration
     public function addition() {
			$this->result = $this->number1+$this->number2;   
      	return $this->result;
    }
    public function substraction() {
			$this->result = $this->number1-$this->number2;   
        return $this->result;
    }
    public function multiplication() {
			$this->result = $this->number1*$this->number2;   
        return $this->result;
    }
    public function division() {
			$this->result = $this->number1/$this->number2;   
        return $this->result;
    }
}//end class calculator


$calc = new calculator;
$calc->number1 = 50;
$calc->number2 = 20;
?>

<br />
<br />
<br />

<div>Addition <?php echo $calc->addition(); ?></div>
<div>substraction <?php echo $calc->substraction(); ?></div>
<div>multiplication <?php echo $calc->multiplication(); ?></div>
<div>division <?php echo $calc->division(); ?></div>
<br />
<br />
<?php

/* *************************************************************************************** */
/* *************************************************************************************** */
/* *************************************************************************************** */
/* *************************************************************************************** */
class person{
   public $name;
   public $age;
    function __construct($n,$a) {
    $this->name = $n;
    $this->age = $a;
 
    }

}//end class person


class not_shy_person extends person{
public $my_age;

function show_age(){
$this->my_age = parent::age;
return $my_age;
}//end function

}//end class not_shy_person extends person


$a = new person("qwerty",35);
echo "<br/>" . $a->name;
//	 echo "<br/>" . $a->age;


$b = new not_shy_person("azerty",99);
echo "<br/>" . $b->name;
echo "<br/>" . $b->age;


/* *************************************************************************************** */
/* *************************************************************************************** */
/* *************************************************************************************** */
/* *************************************************************************************** */
/* *************************************************************************************** */


define("ALL_U", 1);
define("ALL_L", 2);

class peoplename{
		  
		  //properties
		  public $fullname;
		  public $format;
		  

		  //methods
		  function formatname(){
		  		switch($this->format){
  				case 1:
    				echo strtoupper($this->fullname);
    				break;
  				case 2:
    				echo strtolower($this->fullname);
    				break;
  				default:
    				echo $this->fullname;
				}//end switch($format)
		  
		  }//end function formatname()

}//end class peoplename


$myname = new peoplename;
$myname->fullname = "Georges Brisset";
$myname->format = ALL_L;

?>



<br />
<br />
<br />
<div><?php $myname->formatname(); ?></div>

<?php 



?> 


</body></html>