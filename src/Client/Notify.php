<?php

namespace JsonRPC\Client;

/**
 * Сериализуемый объект уведомления
 */
class Notify implements \JsonSerializable
{

    /** @var string */
    protected $method;
    /** @var array */
    protected $params;

    /**
     * @param string $method Название удаленного метода
     * @param array $params Массив параметров, которые будут переданы на RPC-сервер
     */
    public function __construct($method, $params = [])
    {
        $this->method = $method;
        $this->params = $params;
    }

    /**
     * @return array array('jsonrpc' => '2.0', 'method' => string, 'params' => array)
     */
    public function jsonSerialize()
    {
        return [
            'jsonrpc' => '2.0',
            'method'  => $this->method,
            'params'  => $this->params
        ];
    }

}