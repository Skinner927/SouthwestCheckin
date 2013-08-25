<?php
/*
  Copyright (C) 2013  Dennis Skinner skinner927@gmail.coms

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License along
  with this program; if not, write to the Free Software Foundation, Inc.,
  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/
require_once('db.php');
require('config.php');

// Database Path
$sqliteDb = '../checkin.sqlite3';
// Default Table
define ("TABLECHECKIN", "checkin");

// Change quotes for SQLITE3
DB::$i = '"';

// If the DB is new, we default fill it
if (!file_exists($sqliteDb)) {
  $defaultFill = true;
}

// Connect to the database
DB::$c = new PDO('sqlite:'.$sqliteDb, '', '', array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));
    
// The db is new, fill it
if (isset($defaultFill) && $defaultFill === true) {
  
  // Create and fill the airport table
  include 'db/airportfill.php';
  DB::query($airportFill);
  
  // This is the checkin table
  DB::query('CREATE TABLE checkin (
    id INTEGER PRIMARY KEY, 
    fname TEXT, 
    lname TEXT, 
    confirmation TEXT,
    datetime NUMERIC,
    created NUMERIC,
    run NUMERIC,
    success NUMERIC,
    password TEXT,
    salt TEXT,
    email TEXT
    )');
  
  // test data, remove on release
  // Default passwords are: banana
  $checkin = array(
    'fname' => 'bob',
    'lname' => 'builder',
    'confirmation' => 'XYZ123',
    'datetime' => 1383932307,
    'created' => 1375994309,
    'password' => '40a52f71e03e9a8dfa276bc552e7cacf966f37ff38c77cee705e1b4c3886ae1c58b60e87b172c0ef637fdae9c6f84fd652b1d7cc7826b7331dfe92c05437ef67',
    'salt' => 'apple'
    );
  DB::insert(TABLECHECKIN, $checkin);
  
  $checkin = array(
    'fname' => 'Jill',
    'lname' => 'Funny',
    'confirmation' => '123QRX',
    'datetime' => 1383932307,
    'created' => 1375994309,
    'password' => '40a52f71e03e9a8dfa276bc552e7cacf966f37ff38c77cee705e1b4c3886ae1c58b60e87b172c0ef637fdae9c6f84fd652b1d7cc7826b7331dfe92c05437ef67',
    'salt' => 'apple'
    );
  DB::insert(TABLECHECKIN, $checkin);
  
  $checkin = array(
    'fname' => 'lucy',
    'lname' => 'frank',
    'confirmation' => '132sdf',
    'datetime' => 1383932307,
    'created' => 1375994309,
    'password' => '40a52f71e03e9a8dfa276bc552e7cacf966f37ff38c77cee705e1b4c3886ae1c58b60e87b172c0ef637fdae9c6f84fd652b1d7cc7826b7331dfe92c05437ef67',
    'salt' => 'apple'
    );
  DB::insert(TABLECHECKIN, $checkin);
}

// Handles checkin post/get/push methods
class Checkin {

  // Validates a data object from the user.
  // $required is an array of properties to check for
  // Returns true if success else an array of errors
  public static function validate($data, $required) {
    
    $dataArray = (array)$data;

    foreach($required as $requirement) {
      
      // simple sanity check
      if(!property_exists($data, $requirement) || empty($dataArray[$requirement])) {
        // Human readable
        if($requirement == 'fname')
          $requirement = 'first name';
        else if ($requirement == 'lname')
          $requirement = 'last name';
        else if ($requirement == 'confirmation')
          $requirement .= ' number';
        else if ($requirement == 'datetime') {
          $requirement = 'Date\Time';
        } 
          
        return array('error' => ucfirst($requirement).' cannot be empty');
      }
      
      // Special cases
      switch ($requirement) {
        case 'id':
          if(!preg_match('/^\d+$/', $dataArray['id']))
            return array('error' => 'Invalid ID');
        break;
        case 'email' :
          if(filter_var($dataArray['email'], FILTER_VALIDATE_EMAIL) === false)
            return array('error' => 'Invalid email address');
        break;
        case 'confirmation' :
          if(!preg_match('/^\w{6}$/', $dataArray['confirmation']))
            return array('error' => 'Invalid confirmation number');
        break;
        case 'datetime' :
          if(!preg_match('/^\d{2}\/\d{2}\/\d{4} \d{2}:\d{2} (AM|PM)$/', $dataArray['datetime']))
            return array('error' => 'Invalid Date\Time');
        break;        
      }      
    }
    
    // If we get to here, it's all good
    return true;
  }
  
  // converts the html style date/time to unix epoch
  private static function convertDateTimeToUnix($datetime) {
    
    $d = date_create_from_format('m/d/Y h:i A', $datetime);
    return $d->format('U');    
  }

  // Gets the checking with the specified id or all if no id
  public static function get($id = 0) {    
    if($id == null || $id == 0)
      return DB::fetch('SELECT id, lname, fname, substr(confirmation, 1, 1) || "****" || substr(confirmation, -1, 1) as confirmation, datetime FROM "'.TABLECHECKIN.'" ORDER BY datetime, lname, fname');
    else
      return DB::row('SELECT id, lname, fname, substr(confirmation, 1, 1) || "****" as confirmation, datetime FROM "'.TABLECHECKIN.'" WHERE id = ?', array($id));    
  }
  
  // Updates a Checkin row
  public static function update($request) {
    // Get our post data
    $data = json_decode($request->data['data']);    
    
    // Validate
    $result = self::validate($data, array('id', 'fname', 'lname', 'confirmation', 'password', 'datetime'));
    if($result !== true) {
      return $result;
    }
    
    // Grab the row's password and salt
    $row = DB::row('SELECT password, salt FROM "'.TABLECHECKIN.'" WHERE id = ?', array($data->id));
    
    // Did we fail?
    if($row === false) {
      return array('error' => "Invalid ID, Couldn't find row");
    }
    
    // Password is double sha512 hashed from client, add the salt and hash again to compare
    $clientPass = trim($data->password) . $row->salt;
    $clientPass = hash('sha512', $clientPass);
    
    // Valid pass?
    if($clientPass != $row->password) {
      return array('error' => "Invalid Password!");
    }
    
    // Fix the datetime to be in proper format
    $data->datetime = self::convertDateTimeToUnix($data->datetime);
    
    // Remove the password property because we don't want to update that
    unset($data->password);
    
    // If there isn't a new confirmation number, don't change it
    if(strpos($data->confirmation, '*') !== false)
      unset($data->confirmation);
    else
      $data->confirmation = strtoupper($data->confirmation);
    
    // We got here? Update it!
    if(DB::update(TABLECHECKIN, (array)$data, $data->id) < 1)
      return array('error' => 'An unknown error occurred. Please try again.');
    
    // Nothing's wrong!
    return array();
  }
  
  // Deletes a row 
  public static function delete($request) {
    // Get our post data
    $data = json_decode($request->data['data']);    
    
    // Validate
    $result = self::validate($data, array('id', 'password'));
    if($result !== true) {
      return $result;
    }
    
    // Grab the row's password and salt
    $row = DB::row('SELECT password, salt FROM "'.TABLECHECKIN.'" WHERE id = ?', array($data->id));
    
    // Did we fail?
    if($row === false) {
      return array('error' => "Invalid ID, Couldn't find row");
    }

    // Password is double sha512 hashed from client, add the salt and hash again to compare
    $clientPass = trim($data->password) . $row->salt;
    $clientPass = hash('sha512', $clientPass);
    
    // Valid pass?
    if($clientPass != $row->password) {
      return array('error' => "Invalid Password! ");
    }
    
    // We got here? Delete it!    
    if(DB::query('DELETE FROM "'.TABLECHECKIN.'" WHERE id = ?', array($data->id)) === false)
      return array('error' => 'An unknown error occurred. Please try again.');
    
    // Nothing's wrong!
    return array();
  }
  
  // Creates a new Checkin row
  public static function create($request) {
    // Get the post data
    $data = json_decode(json_encode($request->data['data']));
    
    // Validate
    $result = self::validate($data, array('fname', 'lname', 'email', 'confirmation', 'password', 'datetime'));
    if($result !== true) {
      return $result;
    }
    
    // Create password salt
    $data->salt = bin2hex(openssl_random_pseudo_bytes(8));
    $data->password = hash('sha512', $data->password.$data->salt);
    
    // UCase the Confirmation
    $data->confirmation = strtoupper($data->confirmation);
    
    // Fix the time
    $data->datetime = self::convertDateTimeToUnix($data->datetime);
    
    $data->created = time();
    
    $data->success = 0;
    
    // Stick it in the DB    
    if(DB::insert(TABLECHECKIN, (array)$data) < 1)
      return array('error' => 'An unknown error occurred. Please try again.');
    
    // Nothing's wrong
    return array();    
  }
}
?>