<?php

namespace JsonRPC\Client;

class Notify implements \JsonSerializable
{

    protected $method;
    protected $params;

    public function __construct($method, $params = [])
    {
        $this->method = $method;
        $this->params = $params;
    }

    public function jsonSerialize()
    {
        return [
            'jsonrpc' => '2.0',
            'method'  => $this->method,
            'params'  => $this->params
        ];
    }

}