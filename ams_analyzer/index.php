



<?php 




// ---------------------------------------------------
// -- Config - instantiation -------------------------
// ---------------------------------------------------

//ams core files
require 'ams_core/ams_config.php';
require 'ams_core/ams_config_reports.php'; //could be required when needed with the report page - TBD - GB 2020-04-22
require 'ams_core/ams_connections.php';// Sets $ams_pdo

// ---------------------------------------------------
// -- Classes - instantiation ------------------------
// ---------------------------------------------------

//ams libraries
require 'ams_classes/ams_utilities.php';

$ams_utilities = new ams_utilities($ams_pdo);


// ---------------------------------------------------
// -- Content  ---------------------------------------
// ---------------------------------------------------

// Available pages
$pages_to_load['test'] = "_test_page.php";// Default page
$pages_to_load['f_upload'] = "file_upload.php";
$pages_to_load['kw_harvest'] = "kw_harvest_cleaner.php";
$pages_to_load['c_report'] = "campaign_report.php";

// Setting default page
$q = "test";
$page_requested = $pages_to_load[$q];

// If these fail, default page is loaded
if(isset($_GET['q'])) $q = $_GET['q'];
if(array_key_exists($q,$pages_to_load)) $page_requested = $pages_to_load[$q];

$q_string = $_SERVER['QUERY_STRING'];
parse_str($q_string, $q_array);

// $ams_utilities->better_vardump($q_string,3);// 0- green; 1-red; 2-grey; 3-yellow   
// $ams_utilities->better_vardump($q_array,3);// 0- green; 1-red; 2-grey; 3-yellow   
// exit();

include "ams_templates/ams_template_main.php";



// ---------------------------------------------------
// -- Closing  ---------------------------------------
// ---------------------------------------------------

require 'ams_core/ams_closing.php';// Kills $ams_pdo


  ?>

