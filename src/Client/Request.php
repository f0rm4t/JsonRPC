<?php

namespace JsonRPC\Client;

use JsonRPC\Client\Notify;

/**
 * Сериализуемый объект запроса
 */
class Request extends Notify
{

    /** @var string */
    protected $method;
    /** @var string */
    protected $params;
    /** @var string */
    protected $id;

    /**
     * @param string $method Название удаленного метода
     * @param array $params Массив параметров, которые будут переданы на RPC-сервер
     * @param string $id Идентификатор запроса. Если не указан явно, будет сгенерирован автоматически
     */
    public function __construct($method, $params = [], $id = null)
    {
        parent::__construct($method, $params);

        $this->id = $id ?: mt_rand();
    }

    /**
     * @return array array('jsonrpc' => '2.0', 'method' => string, 'params' => array, 'id' => string)
     */
    public function jsonSerialize()
    {
        return parent::jsonSerialize() + [
            'id' => $this->id
        ];
    }

}