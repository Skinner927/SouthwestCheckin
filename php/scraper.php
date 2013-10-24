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
require_once('klogger.php');
require_once('goutte.phar');
require_once('config.php');

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

  class Scraper {
    
    /**
     * Gets flight data from a given airItinerary flight block
     *
     * @throws InvalidArgumentException If there is no data in the flight blocks
     * @param Crawler $flightBlock A Crawler whose root is an #airItinerary block
     * @return array datetime (UTC) and airport (FAA) from the block or null on failure
     */     
    protected static function GetFlights(Crawler $flightBlock) {
      $log = new KLogger('./logs/scraper', KLogger::INFO);
      
      $date = trim($flightBlock->filter('span.travelDateTime')->text());
      $time = trim($flightBlock->filter('.departure>strong>span')->text());
      $airport = trim($flightBlock->filter('td.routingDetailsStops>strong')->text());
      
      // Get the Airport's FAA code
      $matches = null;
      preg_match('/\((\w{3})\)/', $airport, $matches);
      if(!isset($matches[1])){
        $log->logFatal('Could not find FAA code in: '.$airport);
        throw new InvalidArgumentException('No FAA code found');
      }
      $airport = $matches[1];
      
      // Database should already be connected for anyone using this class
      $port = DB::row('SELECT * FROM "'.TABLEAIRPORT.'" WHERE "airport"=?', array($airport));
      
      // Get the timezone
      $timezone = new DateTimeZone($port->timezone);
      
      // Create the date/time object
      $datetime = new DateTime($date.' '.$time, $timezone);
      
      // Switch time to UTC
      $datetime->setTimezone(new DateTimeZone("UTC"));      

      // Return as array
      return array('datetime' => $datetime->format('U'), 'airport' => $airport);
    }
  
    /**
     * Gets the flights from the given user data
     *
     * @param object $userData $userData should be an object with the following properties:
     *                         fname, lname, confirmation
     * @returns array Array of flights that were found. Each flight array contains 'date', 
     *                'time' (in UTC), and FAA formatted 'airport' OR string of error(s) OR null on fatal error
     */
    public static function Flights($userData) {
      // Creates a new logger
      $log = new KLogger('./logs/scraper', LOGLEVEL);
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
      
      // Verify response code
      if($response->getStatus() >= 400) {
        $log->logError('Cannot get air reservations. Status code: '.$response->getStatus(), $client);
        return 'There was trouble accessing the Southwest website. Please try again (ERR:sc0-'.$response->getStatus().')';
      }
      
      // See if there were errors on the page
      $errors = $crawler->filter('div>#error_wrapper>ul')->filter('li')->each(function(Crawler $node, $i){        
        // This takes off the SW error codes
        return trim(substr($node->text(), 0, strpos($node->text(), '(')))."\n";
      });
      // Return the errors if we have them
      if (count($errors) > 0) {
        $log->logWarn(implode($errors), $userData);
        
        // The standard error message is super long and doesn't pertain to our end users. If that's the error, fix it
        if(strpos(implode($errors), 'unable to retrieve your reservation from our database') === false)
          return implode($errors);
        return 'Could not find reservation. Please check your name and confirmation number.';
      }

      // Attempt to pull the flight data
      try {
        $depart = self::GetFlights($crawler->filter('#airItinerarydepart'));        
      } catch (InvalidArgumentException $e) {
        $log->logCrit('airItinerarydepart contained no data', $crawler->html());
        return null;
      }
      
      try {
        $return = self::GetFlights($crawler->filter('#airItineraryreturn'));        
      } catch (InvalidArgumentException $e) {
        $log->logCrit('airItineraryreturn contained no data', $crawler->html());
        return null;
      }
      
      // If we got to here, we should have the flights
      return array($depart, $return);
      
    }
  
  }
?>