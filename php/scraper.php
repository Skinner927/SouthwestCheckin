<?php
/*
  Copyright (C) 2013  Dennis Skinner skinner927@gmail.com

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
require_once 'klogger.php';
require_once 'goutte.phar';
use Goutte\Client;

  class Scraper {
  
    // Gets the flights from the given user data
    // $userData -> fname, lname, email, confirmation
    function Flights($userData) {
      // Creates a new logger
      $log = new KLogger('./logs/scraper');
      // Create a new web client
      $client = new Client();

      /* Pull the flights from SW via the confirmation */
      // this is a testing address. True address is below.
      $client->request('POST', 'http://localhost/SouthwestCheckin/southwesttest/flight/view-air-reservation.php', 
      //$client->request('POST', 'https://www.southwest.com/flight/view-air-reservation.html', 
        array(
          'searchType' => 'ConfirmationNumber',
          'confirmationNumberFirstName' => $userData->fname,
          'confirmationNumberLastName' => $userData->lname,
          'confirmationNumber' => $userData->confirmation,
          'submitButton' => 'Continue'
        ));
      $response = $client->getResponse();  
      $crawler = $client->getCrawler();
      
      
    }
  
  }
?>