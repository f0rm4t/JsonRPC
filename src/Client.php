<?php

namespace JsonRPC;

use JsonRPC\Client\Request;
use JsonRPC\Client\Notify;
use JsonRPC\Client\Response;
use JsonRPC\Exception\Curl as CurlException;

class Client
{

    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function request($method, $params = [], $id = null)
    {
        return $this->send(new Request($method, $params, $id));
    }

    public function notify($method, $params = [])
    {
        try {
            $this->send(new Notify($method, $params));
        } catch (\Exception $e) {

        }
    }

    public function send(\JsonSerializable $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $this->url,
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($request),
            CURLOPT_HTTPHEADER     => ['Content-type: application/json', 'Accept: application/json']
        ]);

        $response   = curl_exec($curl);
        $error_code = curl_errno($curl);
        $error_msg  = curl_error($curl);

        curl_close($curl);

        if ( ! empty($error_code)) {
            throw new CurlException($error_msg, $error_code);
        }

        return new Response($response);
    }

}