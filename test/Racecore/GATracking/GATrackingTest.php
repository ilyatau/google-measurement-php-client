<?php
namespace Racecore\GATracking;

use Racecore\GATracking\Tracking\Ecommerce as Ecommerce;
use Racecore\GATracking\Tracking\Exception;
use Racecore\GATracking\Tracking\Page;
use Racecore\GATracking\Tracking\Campaign;

/**
 * Class GATrackingTest
 *
 * @author      Marco Rieger
 * @package       Racecore\GATracking
 */
class GATrackingTest extends AbstractGATrackingTest {

    /** @var  GATracking */
    private $tracking;

    public function setUp()
    {
        $this->tracking = new GATracking();
    }

    public function testTrackingEventsCanAddedToTheStack()
    {
        $tracking = $this->tracking;

        $eventPage = new Page();
        $eventException = new Exception();
        $eventTransaction = new Ecommerce\Transaction();

        $tracking->addTracking( $eventPage );
        $tracking->addTracking( $eventException );
        $tracking->addTracking( $eventTransaction );

        $events = $tracking->getEvents();
        $this->assertEquals( 3, count($events));
        $this->assertEquals($eventPage, $events[0] );
        $this->assertEquals($eventException, $events[1] );
        $this->assertEquals($eventTransaction, $events[2] );

    }

    public function testClientIDisGeneratedFromGoogleCookie(){

        $tracking = $this->tracking;

        $_COOKIE['_ga'] = 'GA1.3.123456789.1234567890';
        $clientID = $tracking->getClientID();

        $this->assertEquals('123456789.1234567890', $clientID);
    }

    public function testCustomUuidClientIDfromGoogleCookie(){

        $tracking = $this->tracking;

        $_COOKIE['_ga'] = 'GA1.3.35009a79-1a05-49d7-b876-2b884d0f825b';
        $clientID = $tracking->getClientID();

        $this->assertEquals('35009a79-1a05-49d7-b876-2b884d0f825b', $clientID);
    }

    public function testAccountIDcanSet()
    {
        $tracking = $this->tracking;
        $tracking->setAccountID('foo');

        $accountID = $tracking->getAccountID();
        $this->assertEquals('foo', $accountID);
    }

    public function testLastResponseIsStoredInContainer()
    {
        $tracking = $this->tracking;
        $tracking->addResponse('foo');

        $last_response = $tracking->getLastResponse();
        $this->assertEquals('foo', $last_response);

        $tracking->addResponse('bar');
        $last_response_stack = $tracking->getLastResponseStack();
        $this->assertEquals(array('foo', 'bar'), $last_response_stack );
    }

		public function testProxycanSet()
    {
        $tracking = $this->tracking;
        $tracking->setProxy(true);

        $proxy = $tracking->getProxy();
        $this->assertEquals(true, $proxy);
    }
    
    public function testUserIDcanSet()
    {
        $tracking = $this->tracking;
        $tracking->setUserID(1234);

        $userID = $tracking->getUserID();
        $this->assertEquals(1234, $userID);
    }
}
 