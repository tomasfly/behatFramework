<?php

/**
 * Created by PhpStorm.
 * User: Tomas
 * Date: 31/01/2016
 * Time: 09:47 AM
 */
class Connection
{

    /**
     * Connection constructor.
     */
    public function __construct()
    {
    }

    public static function sendRequest($request, $method="GET")
    {
        $url = $request;
        $response = \Httpful\Request::get($url)
            ->expectsJson()
            ->withXTrivialHeader('Just as a demo')
            ->send();
        echo "{$response->body->meta->code}";
        echo "{$response->body->data->provider_id}";
        $response_code = $response->body->meta->code;
        echo "response code is" . $response_code;
    }

}