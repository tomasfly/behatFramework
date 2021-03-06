<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 31/01/2016
 * Time: 09:47 AM
 */
class Connection
{

    private $response;

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * Connection constructor.
     */
    public function __construct()
    {
    }

    public function sendRequest($request, $method)
    {
        if ($method == "GET") {
            $url = $request;
            $response = \Httpful\Request::get($url)
                ->expectsJson()
                ->send();
            $this->setResponse($response);
        }

        if ($method == "PUT") {
            $url = $request;
            $response = \Httpful\Request::put($url)
                ->expectsJson()
                ->send();
            $this->setResponse($response);
        }

        if ($method == "DELETE") {
            $url = $request;
            $response = \Httpful\Request::delete($url)
                ->expectsJson()
                ->send();
            $this->setResponse($response);
        }

    }

}