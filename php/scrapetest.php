<?php
require_once 'goutte.phar';

//http://api.symfony.com/2.0/Symfony/Component/BrowserKit/Client.html
// http://symfony.com/doc/current/components/dom_crawler.html

use Goutte\Client;


$client = new Client();

/* Pull the flights from SW via the confirmation */
$client->request('POST', 'http://localhost/SouthwestCheckin/southwesttest/flight/view-air-reservation.php', 
//$client->request('POST', 'https://www.southwest.com/flight/view-air-reservation.html', 
  array(
    'searchType' => 'ConfirmationNumber',
    'confirmationNumberFirstName' => 'John',
    'confirmationNumberLastName' => 'Smith',
    'confirmationNumber' => 'A3GKN5',
    'submitButton' => 'Continue'
  ));
$response = $client->getResponse();  
$crawler = $client->getCrawler();

// Debug so we can see
echo '<h1>Response code: ' . $response->getStatus() . '</h1>';
print $response->getContent();


// Verify the request was ok!
if($response->getStatus() >= 400) {
  echo '<h1>Bad Response Code : '.$response->getStatus().'</h1>';
  exit;
}

// Returns flight data as an array (no point in making an object with no methods)
function getFlights($airItinerary) {
  $date = $airItinerary->filter('span.travelDateTime')->text();
  $time = $airItinerary->filter('.departure>strong>span')->text();
  $airport = $airItinerary->filter('td.routingDetailsStops>strong')->text();
  
  
  
  
  // Return as array
  return array('date' => $date, 'time' => $time, 'airport' => $airport);
}

// Now try and find the flights
$depart = getFlights($crawler->filter('#airItinerarydepart'));
$return = getFlights($crawler->filter('#airItineraryreturn'));

// Barf for debug
echo '<hr>';
echo '<h1>Departure Date: ' . $depart['date'] . '</h1>';
echo '<h1>Departure Time: ' . $depart['time'] . '</h1>';
echo '<h1>Departure Airport: ' . $depart['airport'] . '</h1>';

echo '<hr>';
echo '<h1>Return Date: ' . $return['date'] . '</h1>';
echo '<h1>Return Time: ' . $return['time'] . '</h1>';
echo '<h1>Return Airport: ' . $return['airport'] . '</h1>';





?>