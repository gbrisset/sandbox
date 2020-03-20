<?php 
include 'zx_dbconn.php';
include 'zx_functions.php';
?>

<?php include 'zx_header.php';?>
<?php include 'zx_footer.php';?>


<?php 

/* ------------------------------------------------------------------------------------------------ */
/* ---- SQL --------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------ */

if (isset($_POST['test_title']))
{
 $test_title=$_POST['test_title'];
 
$sql = "INSERT INTO zq_test (test_title) VALUES ('" . $test_title . "')";
mysql_query($sql,$conn);
 
 
$sql = "SELECT * FROM zq_test";
$rs = mysql_query($sql,$conn);

while($row = mysql_fetch_array($rs))
  {
  echo $row['test_id'] . " - " . $row['test_title'] . "<br />";
  }
}//end if -  (isset($_POST['test_title']))



/* ------------------------------------------------------------------------------------------------ */
/* ---- LIST $_POST ITEMS ------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------ */

echo "<br/><br/>List of POST info<br/><br/>";
foreach($_POST as $elementname => $elementvalue) {echo "$elementname  = $elementvalue" . "<br/>";}
echo "<br/><br/>";


?>

<?php 
/* ------------------------------------------------------------------------------------------------ */
/* ---- Sample field with validation -------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------ */
/* ---- javascript:validate_field(value to test,span id for prompt message,validation type,status 'still typing - 0, done typing - 1',required 'no - 0, yes - 1') --- */
/* ------------------------------------------------------------------------------------------------ */
?>	
      	<label for="recruiter_name" style="position:absolute;left:20px;top:20px;height:20px;">Name:</label>
      	<input name="recruiter_name" type="text" class="input_txt" tabindex="1" 
							 style="position:absolute;left:120px;top:18px;width:200px;height:20px;" 
							 onkeyup="javascript:validate_field(this.value,'recruiter_name_validation','zipcode',0,1);"
							 onchange="javascript:validate_field(this.value,'recruiter_name_validation','zipcode',1,1);"
							 value=""/>
				<span id="recruiter_name_validation" style="position:absolute;left:340px;top:20px;height:20px;">Required</span>

				
				
				
<!-- --------------------------------------------------------------------------------------- -->	
<!-- ----- HTML COMMENTS ------------------------------------------------------------------- -->	
<!-- --------------------------------------------------------------------------------------- -->	

<!-- --------------------------------------------------------------------------------------- -->	
<!-- ----- BELOW IS DRAFT CODE ------------------------------------------------------------- -->	
<!-- --------------------------------------------------------------------------------------- -->	

<!-- --------------------------------------------------------------------------------------- -->	
<!-- ----- ABOVE IS DRAFT CODE ------------------------------------------------------------- -->	
<!-- --------------------------------------------------------------------------------------- -->	

