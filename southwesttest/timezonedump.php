<?php
/****
Takes the phpAirports $airports array and finds the timezone via the imported Airports table and exports needed data to the compiledAirports table which 
should later be exported and put in the main db or something like that.
*/
include 'phpairports.php';

//echo '<pre>'.print_r($airports['FLL'], true).'</pre>';

require_once('db.php');

// Database Path
$sqliteDb = 'Airports.sqlite3';

// Change quotes for SQLITE3
DB::$i = '"';

// Connect to the database
DB::$c = new PDO('sqlite:'.$sqliteDb, '', '', array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));    
///- database connected

// Create the second table
if (count(DB::fetch('SELECT name FROM sqlite_master WHERE "type"="table" AND "name"=?',array('compiledAirports'))) < 1) {
  DB::query('CREATE TABLE compiledAirports (
    id INTEGER PRIMARY KEY, 
    airport TEXT, 
    utc_offset NUMERIC, 
    dst NUMERIC
    )');
}


//$airports is from the SW website (idk why I keep forgetting this)
foreach ($airports as $air) {
  // DB matchup
  // air['code'] -> faa
  
  if (strlen($air['state_federal_unit']) < 1) {
    // Fake airport. It's a SW 'Area' code
    continue;
  }
  
  var_dump($air);

  $port = DB::row('SELECT * FROM "Airports" WHERE "faa"=?', array($air['code']));
  
  echo var_dump($port);
  
  if($port->country != 'United States') {
    echo '<h1>NOT IN THE US!</h1>';
    if($air['country_code'] != 'US')
      exit;
  }
  
  // Doesn't use DST
  if($port->dst != 'A')
    echo '<h1>TIMEZONE</h1>';
    
  // Insert values into table
  $ap = array(
    'airport' => $port->faa,
    'utc_offset' => (int)$port->utc,
    'dst' => ($port->dst == 'A')? 1 : 0
    );
  var_dump(DB::insert('compiledAirports', $ap));
  
  echo '<hr>';
}

$timezone = '+0:00';
$timezone = preg_replace('/[^0-9]/', '', $timezone) * 36;
$timezone_name = timezone_name_from_abbr(null, $timezone, true);
date_default_timezone_set($timezone_name);
echo date('D d M Y H:i:s');

?>