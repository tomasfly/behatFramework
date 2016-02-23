<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 31/01/2016
 * Time: 09:13 AM
 */
class RequestsURL
{
    private $sonar_url = "http://uk9c0jvb9f6nvxvhursp.olapic.com/v1/places";
    private $request;


    /**
     * RequestsURL constructor.
     * @param $provider_name
     * @param $provider_place_id
     * @internal param string $sonar_url
     * @internal param $request
     */
    public function __construct($provider_name, $provider_place_id)
    {
        $place = new Place($provider_name, $provider_place_id);
        $request = $this->sonar_url . "/" . $place->getProviderName() . "/" . $place->getProviderPlaceId();
        $this->setRequest($request);
    }

    function __toString()
    {
        return $this->getRequest();

    }

    /**
     * @return string
     */
    public function getSonarUrl()
    {
        return $this->sonar_url;
    }


    /**
     * @param string $sonar_url
     */
    public function setSonarUrl($sonar_url)
    {
        $this->sonar_url = $sonar_url;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }


}