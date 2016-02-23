<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 31/01/2016
 * Time: 09:06 AM
 */
class Place
{
    private $provider_name;
    private $provider_place_id;

    /**
     * Place constructor.
     * @param $provider_name
     * @param $provider_place_id
     * @internal param $uuid
     */
    public function __construct($provider_name, $provider_place_id)
    {
        $this->provider_name = $provider_name;
        $this->provider_place_id = $provider_place_id;
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

}