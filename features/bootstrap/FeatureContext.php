<?php
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode, Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
// require_once 'PHPUnit/Autoload.php';
// require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
require_once 'connection/Connection.php';
require_once 'model/RequestsURL.php';
require_once 'model/Place.php';

class FeatureContext implements \Behat\Behat\Context\Context, SnippetAcceptingContext
{

    private $provider_name;
    private $provider_place_id;
    private $place;
    private $request_url;
    private $response;
    private $logger;

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param mixed $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }


    /**
     * @return mixed
     */
    public function getProviderName()
    {
        return $this->provider_name;
    }

    /**
     * @param mixed $provider_name
     */
    public function setProviderName($provider_name)
    {
        $this->provider_name = $provider_name;
    }

    /**
     * @return mixed
     */
    public function getProviderPlaceId()
    {
        return $this->provider_place_id;
    }

    /**
     * @param mixed $provider_place_id
     */
    public function setProviderPlaceId($provider_place_id)
    {
        $this->provider_place_id = $provider_place_id;
    }

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param mixed $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * @return mixed
     */
    public function getRequestUrl()
    {
        return $this->request_url;
    }

    /**
     * @param mixed $request_url
     */
    public function setRequestUrl($request_url)
    {
        $this->request_url = $request_url;
    }

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters
     *            context parameters (set them up through behat.yml)
     */
    public function __construct()
    {
        $logger = new Katzgrau\KLogger\Logger(__DIR__ . '/logs');
        $this->setLogger($logger);

    }

    /**
     * @BeforeScenario @deleteplace
     */
    public function deletePlaceBefore()
    {
        $this->genericRequest("DELETE");
    }

    /**
     * @BeforeScenario @addPlaces
     */
    public function addPlacesBeforeScenario()
    {
        $this->genericRequest("PUT");
    }

    /**
     * @AfterScenario @deleteplace
     */
    public function deletePlaceAfter()
    {
        $this->genericRequest("DELETE");
    }

    public function genericRequest($method)
    {
        $this->setProviderPlaceId("96980666115");
        $this->setProviderName("facebook");
        $this->iSendRequestUsingMethod($method);

        $this->setProviderPlaceId("4a72174bf964a52055da1fe3");
        $this->setProviderName("foursquare");
        $this->iSendRequestUsingMethod($method);
    }


    /**
     * @When /^I send request using "([^"]*)" method$/
     */
    public function iSendRequestUsingMethod($arg1)
    {
        $name = $this->getProviderName();
        $place = $this->getProviderPlaceId();
        $request = new RequestsURL($name, $place);
        $request->getRequest();
        $this->getLogger()->INFO('Sending request: ' . $request);
        $con = new Connection();
        $con->sendRequest($request, $arg1);
        $response = $con->getResponse();
        $this->setResponse($response);
    }


    /**
     * @Then /^response code is "([^"]*)"$/
     */
    public function responseCodeIs($arg1)
    {
        $response = $this->getResponse();
        $response_code = $response->body->meta->code;
        if ($response_code == $arg1) {

            $this->getLogger()->INFO('Status code ' . $response_code . ' is expected');
        } else {

            $this->getLogger()->INFO('Status code ' . $response_code . ' is not expected');
            PHPUnit_Framework_Assert::assertEquals($arg1, $response_code,
                "The response is not expected, should be " . $arg1 . " but is " . $response_code);
        }
    }

    /**
     * @Given /^provider name is (.*)$/
     */
    public function providerNameIs($PROVIDER_NAME)
    {
        $this->setProviderName($PROVIDER_NAME);
    }

    /**
     * @Given /^provider place id is (.*)$/
     */
    public function providerPlaceIdIs($PROVIDER_PLACE_ID)
    {
        $this->setProviderPlaceId($PROVIDER_PLACE_ID);
    }

    /**
     * @Then /^JSON contains the following data:$/
     */
    public function jsonContainsTheFollowingData(TableNode $table)
    {
        $response = $this->getResponse();
        foreach ($table->getRows() as $row) {
            $key = $row[0];
            try {
                $response->body->data->$key;
            } catch (\Symfony\Component\Config\Definition\Exception\Exception $e) {
                PHPUnit_Framework_Assert::fail("not found key is: " . $key);
            }
        }

    }

    /**
     * @Given /^JSON contains the following key value data:$/
     */
    public function jsonContainsTheFollowingKeyValueData(TableNode $table)
    {
        $response = $this->getResponse();
        foreach ($table->getRows() as $row) {
            $key = $row[0];
            $value = $row[1];
            $value_from_response = $response->body->data->$key;
            if ($value == $value_from_response) {
                $this->getLogger()->INFO('Value ' . $value . "matches" . $value_from_response);

            } else {
                PHPUnit_Framework_Assert::fail("Values dont match. Expected is: $value but found:$value_from_response  ");
            }
        }

    }

    /**
     * @Given /^I save UUID$/
     */
    public function iSaveUuid()
    {
        $response = $this->getResponse();
        $uuid = $response->body->data->id;
        $this->setProviderPlaceId($uuid);

    }

    /**
     * @Then response contains the following source information
     */
    public function responseContainsTheFollowingSourceInformation(TableNode $table)
    {
        $response = $this->getResponse();
        foreach ($table->getRows() as $row) {
            $key = $row[0];
            $value = $row[1];
            $value_from_response = $response->body->data->source->$key;
            if ($value == $value_from_response) {
                $this->getLogger()->INFO('Value ' . $value . "matches" . $value_from_response);

            } else {
                PHPUnit_Framework_Assert::fail("Values dont match. Expected is: $value but found:$value_from_response  ");

            }

        }
    }

    /**
     * @Then wait a few seconds
     */
    public function waitAFewSeconds()
    {
        sleep(5);
    }

    /**
     * @Then response code is :code with retry
     */
    public function responseCodeIsWithRetry($code)
    {
        $response = $this->getResponse();
        $response_code = $response->body->meta->code;
        if ($response_code == $code) {

            $this->getLogger()->INFO('Status code ' . $response_code . ' is expected');
        } else {

            sleep(5);
            $this->iSendRequestUsingMethod("DELETE");
            sleep(5);
            $this->iSendRequestUsingMethod("DELETE");
            $response = $this->getResponse();
            $response_code = $response->body->meta->code;
            if ($response_code == $code) {

                $this->getLogger()->INFO('Status code ' . $response_code . ' is expected');
            } else {

                $this->getLogger()->INFO('Status code ' . $response_code . ' is not expected');
                PHPUnit_Framework_Assert::assertEquals($code, $response_code,
                    "The response is not expected, should be " . $code . " but is " . $response_code);
            }

        }
    }


}
