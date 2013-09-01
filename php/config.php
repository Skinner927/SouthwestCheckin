<?php
require_once('../FirePHP/fb.php');

// Set the timezone to local
date_default_timezone_set('America/New_York');

// Website Title
$site['title'] = 'Southwest Auto Check-In';  

// Default db
$db['main'] = '../SWCheckin.sqlite3';

// Default Table
define ("TABLECHECKIN", "checkin");
// Airport table
define ("TABLEAIRPORT", "airports");

// Logging level
require_once('klogger.php');
define("LOGLEVEL", KLogger::INFO);
  
?>