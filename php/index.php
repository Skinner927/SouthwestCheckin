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
require_once 'api.php';
require_once 'flight/Flight.php';

// This is the only user route for this single page app
Flight::route('/', function(){
    Flight::render('home.php');
});

// Returns Checkin rows
Flight::route('GET /api/list(/@id:[0-9]+)', function($id){
  noCache();
  echo json_encode(Checkin::get($id));
});

// Handles an update checkin request
Flight::route('POST /api/update', function(){
  noCache();
  echo json_encode(Checkin::update(Flight::request()));
});

// Handles an update checkin request
Flight::route('POST /api/delete', function(){
  noCache();
  echo json_encode(Checkin::delete(Flight::request()));
});

// Handles adding a new checkin
Flight::route('POST /api/new', function(){
  noCache();
  echo json_encode(Checkin::create(Flight::request()));
});


Flight::start();

function noCache() {
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
}
?>
