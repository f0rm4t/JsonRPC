<?php

namespace JsonRPC\Client;

use JsonRPC\Exception\Json as JsonException;
use JsonRPC\Exception\RPC as RPCException;

class Response
{

    protected $response;

    public function __construct($raw_response)
    {
        $this->response = json_decode($raw_response);

        if ($this->response === null) {
            throw new JsonException('JSON parse error', json_last_error());
        }

        if ( ! empty($this->response->error)) {
            throw new RPCException($this->response->error->message, $this->response->error->code);
        }
    }

    public function __get($property)
    {
        if ( ! isset($this->response->{$property})) {
            return null;
        }

        return $this->response->{$property};
    }

}