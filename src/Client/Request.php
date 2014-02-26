<?php

namespace JsonRPC\Client;

use JsonRPC\Client\Notify;

class Request extends Notify
{

    protected $method;
    protected $params;
    protected $id;

    public function __construct($method, $params = [], $id = null)
    {
        $this->method = $method;
        $this->params = $params;
        $this->id     = $id ?: mt_rand();
    }

    public function jsonSerialize()
    {
        return parent::jsonSerialize() + [
            'id' => $this->id
        ];
    }

}