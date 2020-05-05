<?php 

/* ---------------------------------------------------------------------------------- */
/* -------- KILL THESE TWO LINES ON LIVE SITE --------------------------------------- */
/* ---------------------------------------------------------------------------------- */

  error_reporting(E_ALL);
  ini_set('display_errors', '1');

//---------------------------------------------------

/* ---------------------------------------------------------------------------------- */
/* -------- LOCAL SERVER DETECTION -------------------------------------------------- */
/* ---------------------------------------------------------------------------------- */
// Add local detection for MAMP or other WAMP configuration
// PLEASE NOTE - this does work because a virtual host has been set on WAMP

// $ams_isLocal = false; 
//Cannot use PATH_ABS_ROOT yet
// if ($_SERVER['DOCUMENT_ROOT'] == "C:/wamp64/www/smf/httpdocs") {$ams_isLocal = true; } 


/* ---------------------------------------------------------------------------------- */
/* -------- PATH CONSTANTS ---------------------------------------------------------- */
/* ---------------------------------------------------------------------------------- */


/* ---------------------------------------------------------------------------------- */
/* -------- DATABASE ---------------------------------------------------------------- */
/* ---------------------------------------------------------------------------------- */

    define("DB_HOST", "localhost:3308");//MySQL server on WAMP is using port 3308
    define("DB_NAME", "ams_reports");
    define("DB_CHRS", "utf8");
    define("DB_USER", "root");
    define("DB_PASS", "");

	define("DB_CAMPAIGN_REPORT_TABLE", "campaign_reports");
	define("DB_KEYWORD_REPORTS_TABLE", "keyword_reports");

	define("DB_UPLOADED_FILES_TABLE", "uploaded_files"); // to avoid uploading same file multiple times
	
	define("DB_KEYWORD_HARVEST_TABLE", "keyword_harvest");
	define("DB_KEYWORD_BLACK_LIST_TABLE", "keyword_black_list");
	define("DB_KEYWORD_MASTER_TABLE", "keyword_master");

/* ---------------------------------------------------------------------------------- */
/* -------- META DATA --------------------------------------------------------------- */
/* ---------------------------------------------------------------------------------- */


?>