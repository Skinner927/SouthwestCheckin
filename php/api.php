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
    hash TEXT,
    email TEXT
    )');
    
  $checkin = array(
    'fname' => 'bob',
    'lname' => 'builder',
    'confirmation' => 'XYZ123',
    'datetime' => 1383932307,
    'created' => 1375994309,
    'password' => '31bca02094eb78126a517b206a88c73cfa9ec6f704c7030d18212cace820f025f00bf0ea68dbf3f3a5436ca63b53bf7bf80ad8d5de7d8359d0b7fed9dbc3ab99',
    'salt' => 'apple'
    );
  DB::insert(TABLECHECKIN, $checkin);
  
  $checkin = array(
    'fname' => 'Jill',
    'lname' => 'Funny',
    'confirmation' => '123QRX',
    'datetime' => 1383932307,
    'created' => 1375994309,
    'password' => '31bca02094eb78126a517b206a88c73cfa9ec6f704c7030d18212cace820f025f00bf0ea68dbf3f3a5436ca63b53bf7bf80ad8d5de7d8359d0b7fed9dbc3ab99',
    'salt' => 'apple'
    );
  DB::insert(TABLECHECKIN, $checkin);
  
  $checkin = array(
    'fname' => 'lucy',
    'lname' => 'frank',
    'confirmation' => '132sdf',
    'datetime' => 1383932307,
    'created' => 1375994309,
    'password' => '31bca02094eb78126a517b206a88c73cfa9ec6f704c7030d18212cace820f025f00bf0ea68dbf3f3a5436ca63b53bf7bf80ad8d5de7d8359d0b7fed9dbc3ab99',
    'salt' => 'apple'
    );
  DB::insert(TABLECHECKIN, $checkin);
}

// Handles checkin post/get/push methods
class Checkin {
  // Gets the checking with the specified id or all if no id
  public static function get($id = 0) {    
    if($id == null || $id == 0)
      return DB::fetch('SELECT id, lname, fname, confirmation, datetime FROM "'.TABLECHECKIN.'"');
    else
      return DB::row('SELECT id, lname, fname, confirmation, datetime FROM "'.TABLECHECKIN.'" WHERE id = ?', array($id));    
  }
  
  // Updates a Checkin row
  public static function update($request) {
    // Get our post data
    $data = json_decode($request->data['data']);    
    
    // Grab the row's password and salt
    $row = DB::row('SELECT password, salt FROM "'.TABLECHECKIN.'" WHERE id = ?', array($data->id));
    
    // Did we fail?
    if($row === false) {
      return array('error' => "Invalid ID, Couldn't find row");
    }
    
    // Password is double sha512 hashed from client, add the salt and hash again to compare
    $clientPass = trim($data->password) + $row->salt;
    $clientPass = hash('sha512', $clientPass);
    
    // Valid pass?
    if($clientPass != $row->password) {
      return array('error' => "Invalid Password!");
    }
    
    // Fix the datetime to be in proper format
    $d = date_create_from_format('m/d/Y h:i A', $data->datetime);
    $data->datetime = $d->format('U');
    
    // Remove the password property because we don't want to update that
    unset($data->password);
    
    // We got here? Update it!
    DB::update(TABLECHECKIN, (array)$data, $data->id);
    
    // Nothing's wrong!
    return array();
  }
}
?>