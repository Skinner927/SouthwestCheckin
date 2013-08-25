<?php
require_once 'klogger.php';
require_once 'goutte.phar';
use Goutte\Client;

  class Scraper {
  
    // Gets the flights from the given user data
    // $userData -> fname, lname, email, confirmation
    function Flights($userData) {
      // Creates a new logger
      $log = new KLogger('./logs');
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