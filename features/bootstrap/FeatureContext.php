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
    private $reponse_code;


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

    }

    /**
     * @Given /^provider name is "([^"]*)"$/
     */
    public function providerNameIs($arg1)
    {
        $this->setProviderName($arg1);

    }

    /**
     * @Given /^provider place id is "([^"]*)"$/
     */
    public function providerPlaceIdIs($arg1)
    {
        $this->setProviderPlaceId($arg1);
    }

    /**
     * @When /^I send request using GET method$/
     */
    public function iSendRequestUsingGetMethod()
    {
        $name = $this->getProviderName();
        $place = $this->getProviderPlaceId();
        $request = new RequestsURL($name, $place);
        $request->getRequest();
        echo $request;
        $con = new Connection();
        $con->sendRequest($request);
    }

    /**
     * @Then /^response code is "([^"]*)"$/
     */
    public function responseCodeIs($arg1)
    {
        //throw new PendingException ();
    }
}
