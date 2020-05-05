<?php 



/* ---------------------------------------------------------------------------------- */
/* -------- DB CONNECTIONS ----------------------------------------------------------- */
/* ---------------------------------------------------------------------------------- */

$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHRS;
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$ams_pdo = new PDO($dsn, DB_USER, DB_PASS, $opt);

 // $ams_utilities->better_vardump($dsn,1); // 0- green; 1-red; 2-grey; 3-yellow	



?>