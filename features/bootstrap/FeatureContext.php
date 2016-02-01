<?php
use Behat\Behat\Context\ClosuredContextInterface, Behat\Behat\Context\TranslatedContextInterface, Behat\Behat\Context\BehatContext, Behat\Behat\Exception\PendingException;
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

class FeatureContext extends BehatContext
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
    public function __construct(array $parameters)
    {
        $logger = new Katzgrau\KLogger\Logger(__DIR__ . '/logs');
        $this->setLogger($logger);

    }

    /**
     * @Given /^provider name is "([^"]*)"$/
     * //     */
//    public function providerNameIs($provider_name)
//    {
//        $this->setProviderName($provider_name);
//
//    }

    /**
     * @Given /^provider place id is "([^"]*)"$/
     */
//    public function providerPlaceIdIs($arg1)
//    {
//        $this->setProviderPlaceId($arg1);
//    }

    /**
     * @When /^I send request using GET method$/
     */
    public function iSendRequestUsingGetMethod()
    {

        $name = $this->getProviderName();
        $place = $this->getProviderPlaceId();
        $request = new RequestsURL($name, $place);
        $request->getRequest();
        $this->getLogger()->INFO('Sending request: ' . $request);
        $con = new Connection();
        $con->sendRequest($request);
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
                "The response is not the same, should be " . $arg1 . " but is " . $response_code);
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
            } catch (\Behat\Behat\Exception\Exception $e) {
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
                $this->getLogger()->INFO('Value ' . $value . "matches" . $value);

            } else {
                PHPUnit_Framework_Assert::fail("Values dont match. Check table in feature.");

            }

        }

    }


}
