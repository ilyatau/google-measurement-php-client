<?php

use Racecore\GATracking\Tracking;
use Racecore\GATracking\Exception;

/** Autoloader */
require_once( dirname(__FILE__) . '/../src/Racecore/GATracking/Autoloader.php');
Racecore\GATracking\Autoloader::register(dirname(__FILE__).'/../src/');

/**
 * Setup the class
 */
$options = array(
    'client_create_random_id' => true, // create a random client id when the class can't fetch the current cliend id or none is provided by "client_id"
    'client_fallback_id' => 555, // fallback client id when cid was not found and random client id is off
    'client_id' => null,    // override client id
    'user_id' => null,  // determine current user id

    // adapter options
    'adapter' => array(
        'ssl' => true // use ssl connection to google server
    )

    #// use proxy
    #'proxy' => array(
    #   'ip' => '127.0.0.1', // override the proxy ip with this one
    #   'user_agent' => 'override agent' // override the proxy user agent
    #)
);


$gatracking = new \Racecore\GATracking\GATracking('UA-XXXXXX-X', $options);

/** @var Tracking/Event $event */
$event = $gatracking->createTracking('Event');
$event->setAsNonInteractionHit(true);
$event->setEventCategory('testCat4');
$event->setEventAction('actionTest4');

/** @var Tracking/Event $event */
$event2 = $gatracking->createTracking('Event');
$event2->setAsNonInteractionHit(true);
$event2->setEventCategory('testCat5');
$event2->setEventAction('actionTest5');

$gatracking->sendMultipleTracking(array(
    $event, $event2
));