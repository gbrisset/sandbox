<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<?php 

include('functions.php');
$ddd = new debug("Javascript   EXERCISE ",3); $ddd->show();

  ?>
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ----------------- JAVASCRIPT EXERCISE ---------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------ -->

<script>

	var a = 23;
//--------- above is global scope -----------------------------
//--------- below is function scope -----------------------------
	var outerFunction = function(inputVar) {
		var a = 5;
		var b = inputVar;

		return {
			increment: function() {
				a++;
				b++;
			},
			print: function() {
				console.log(a);
				console.log(b);
			}
		}
	}

	f = outerFunction(43);

	f.increment();
	f.print();
//--------- above is function scope -----------------------------
//--------- below is global scope -----------------------------
	console.log(a);
	
	document.write('console.log(a) = '+a);


</script>


<!-- ------------------------------------------------------------------------------------------ -->
<!-- ----------------- CSS EXERCISE ----------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------ -->
<?php 
$ddd = new debug(" CSS   EXERCISE ",3); $ddd->show();
 ?>
<style>

/*Write a CSS selector that selects the first `<div>` and not the second one. */
div#greeting {font-weight: bold; } 
/*body div:first-of-type {font-weight: bold; } */

/*Write a CSS selector that selects the first `<span>` and not the second one.*/
div.body_text span {font-weight: bold; } 

/**/
span.my_footer {font-weight: bold; }
/* body span:first-of-type {font-weight: bold; } */ 

</style>


		<title>
		</title>
		<body>
			<div id="greeting" class="body_text"> Hello, world! </div>
			<div class="body_text">
				<span> SPAN 1 - Here's some cool text! </span>
			</div>
			<span class="my_footer">SPAN 2 - Sign up for our <a href="/email/"> email list </a> </span>
		
			<div style="margin: 0 0 20px 0">&nbsp;</div>
		
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ----------------- PHP  EXERCISE ---------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------ -->
			
<?php 

$ddd = new debug("PHP   EXERCISE ",3); $ddd->show();


// ----- Given data that looks like this: ---------------------

$retailers = [
    [
        'name' => 'abercrombie and fitch',
        'popularity' => 20,
        'country' => 'US'
    ],
    [
        'name' => 'about you',
        'popularity' => 60,
        'country' => 'DE'
    ],
    [
        'name' => 'amazon',
        'popularity' => 200,
        'country' => 'US'
    ],
    [
        'name' => 'asos',
        'popularity' => 100,
        'country' => 'US'
    ],
    [
        'name' => 'asos',
        'popularity' => 80,
        'country' => 'UK'
  ]
];

//var_dump($retailers);


// --- And the following class: ----------------------

class Retailers {

/* ****************************************** */
		public $mostpopularbycountry; // array
		public $mostpopularbyname; // array
		public $popularities; // array
		public $names; // array


   //list function to check results during development
		public function list_all() {
        global $retailers;		
        $this->names = array_column($retailers, 'name');
    }//end function

    //This is to be called once at object inception or after a new retailer is added to the list
		public function listRetailersByPopularityByCountry() {
			global $retailers;
			$countries = array_column($retailers, 'country');
			foreach($countries as $ck =>$cv){
    			$p=0;
    			foreach($retailers as $rk =>$rv){
        			if ($rv['country']==$cv && $rv['popularity']>$p ){
    							$p=$rv['popularity']; 
    							$this->mostpopularbycountry[$cv] = $rv;
							}//end if
    			}//end foreach
			}//end foreach
		}//end function
	
     //This is to be called once at object inception or after a new retailer is added to the list
		public function listRetailersByPopularityByName() {
        global $retailers;
        $this->mostpopularbyname = array_column($retailers, 'name');
        $this->popularities = array_column($retailers, 'popularity');
        array_multisort($this->popularities, SORT_DESC, $this->mostpopularbyname );
				//mostpopularbyname is now sorted by popularity. Searching this array will produce the first match in that order. 
		}//end function
	
 
/* ****************************************** */

    // Is invoked on each element in the $retailers array
    public function addRetailer($name, $popularity, $country) {
  			global $retailers;
  			$retailers[] = array('name'=>$name, 'popularity'=>$popularity, 'country'=>$country);
				$this->listRetailersByPopularityByCountry();
				$this->listRetailersByPopularityByName();
		}//end function
	
		
    /* 1. Find the most popular retailer for every country *
     *
     */ //  Returns the (string) name of the most popular retailer in a country


    public function mostPopularRetailer_byCountry($country) {
          $mp =  $this->mostpopularbycountry[$country];
					return $mp;
	  }//end function

    /* 2. Write an autocomplete function *
     *
     *    Returns the (string) name of the most popular retailer 
     *    whose name starts with the autocomplete string.
     */  // If the string matches exactly a retailer's name, return that name.
    //public function autocomplete($autocomplete_prefix) {
   
	  public function mostPopularRetailer_byName($autocomplete_prefix) {
        $mpr = "Retailer not found";
        if ($autocomplete_prefix !=''){
    				foreach($this->mostpopularbyname as $k =>$v){
                $pattern = "/^($autocomplete_prefix).*/i";
    						if(0!==preg_match($pattern, $v)){
                $mpr = $v;
                break;
            		}//end if
            }//end foreach
        }//end if 
				
        return $mpr; 
	  }//end function



}//end class


/* ********************************************************* */
/* ***************** OUTPUT ******************************** */
/* ********************************************************* */

echo "<br/>-------- Initial Retailers List --------------";
$r = new Retailers; 
$r->list_all();
$ddd = new debug($r->names,2); $ddd->show();

echo "<br/>-------- Add a retailer and display new list --------------";
echo "<br/>-------- addRetailer('Georges Brisset',300,'US') ----------";

$r->addRetailer('Georges Brisset',300,'US');
$r->list_all();
$ddd = new debug($r->names,0); $ddd->show();

echo "<br/>-------- Most Popular retailers by country--------------";
$r->listRetailersByPopularityByCountry();//initialization of the list
$ddd = new debug($r->mostpopularbycountry,2); $ddd->show();

echo "<br/>-------- Most Popular retailers in US --------------";
$ddd = new debug($r->mostPopularRetailer_byCountry('US'),3); $ddd->show();

echo "<br/>-------- Most Popular retailers in UK --------------";
$ddd = new debug($r->mostPopularRetailer_byCountry('UK'),3); $ddd->show();

echo "<br/>-------- Most Popular retailers in DE --------------";
$ddd = new debug($r->mostPopularRetailer_byCountry('DE'),3); $ddd->show();


$acp = "a";
echo "<br/>-------- Most Popular retailers by name - autocomplete_prefix = '$acp'--------------";
$r->listRetailersByPopularityByName();//initialization of the list (needed only once here)
$ddd = new debug($r->mostPopularRetailer_byName($acp),0); $ddd->show();

$acp = "z";
echo "<br/>-------- Most Popular retailers by name - autocomplete_prefix = '$acp'--------------";
$ddd = new debug($r->mostPopularRetailer_byName($acp),1); $ddd->show();

$acp = "ab";
echo "<br/>-------- Most Popular retailers by name - autocomplete_prefix = '$acp'--------------";
$ddd = new debug($r->mostPopularRetailer_byName($acp),0); $ddd->show();

$acp = "AmA";
echo "<br/>-------- Most Popular retailers by name - autocomplete_prefix = '$acp'--------------";
$ddd = new debug($r->mostPopularRetailer_byName($acp),0); $ddd->show();

$acp = "Asos";
echo "<br/>-------- Most Popular retailers by name - autocomplete_prefix = '$acp'--------------";
$ddd = new debug($r->mostPopularRetailer_byName($acp),0); $ddd->show();

$acp = "";
echo "<br/>-------- Most Popular retailers by name - autocomplete_prefix = '$acp'--------------";
$ddd = new debug($r->mostPopularRetailer_byName($acp),1); $ddd->show();




echo "<br/>---------------------------------------------------------------";
echo "<br/>---------------------------------------------------------------";
echo "<br/>-------- Dump Final Retailer Array - For Control --------------";
echo "<br/>---------------------------------------------------------------";
echo "<br/>---------------------------------------------------------------";

$ddd = new debug($retailers,2); $ddd->show();
echo "<br/>";
echo "<br/>";
echo "<br/>";

?>

			
		</body>
	</html>