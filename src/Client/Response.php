<?php

namespace JsonRPC\Client;

use JsonRPC\Exception\Json as JsonException;
use JsonRPC\Exception\RPC as RPCException;

/**
 * Объект ответа сервера JSON-RPC
 */
class Response
{

    /** @var stdClass */
    protected $response;

    /**
     * @param string $raw_response
     * @throws JsonException Если возникла ошибка во время разбора строки ответа
     * @throws RPCException Если возникла ошибка на удаленном RPC-сервере
     */
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

    /**
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        if ( ! isset($this->response->{$property})) {
            return null;
        }

        return $this->response->{$property};
    }

}