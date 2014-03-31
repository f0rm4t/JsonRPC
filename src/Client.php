<?php

namespace JsonRPC;

use JsonRPC\Client\Request;
use JsonRPC\Client\Notify;
use JsonRPC\Client\Response;
use JsonRPC\Exception\Curl as CurlException;

/**
 * Клиент взаимодействия с сервером JSON-RPC 2.0
 */
class Client
{

    /** @var string */
    protected $url;
    /** @var array */
    protected $curl_opts = [
        CURLOPT_HEADER         => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_HTTPHEADER     => ['Content-type: application/json', 'Accept: application/json']
    ];

    /**
     * @param string $url Полный адрес RPC-сервера
     */
    public function __construct($url, $curl_opts = [])
    {
        $this->url        = $url;
        $this->curl_opts += $curl_opts;
    }

    /**
     * Отправить запрос на сервер.
     * Дополнительно передается уникальный идентификатор запроса.
     *
     * @param string $method Название удаленного метода
     * @param array $params Массив параметров, которые будут переданы на RPC-сервер
     * @param string|null $id Идентификатор запроса. Если не указан явно, будет сгенерирован автоматически
     * @return Response
     */
    public function request($method, $params = [], $id = null)
    {
        $result   = $this->send(new Request($method, $params, $id));
        $response = new Response($result);

        return $response;
    }

    /**
     * Отправить уведомление на сервер.
     * Метод не передает идентификатор запроса и не возвращает никакого результата.
     *
     * @param string $method Название удаленного метода
     * @param array $params Массив параметров, которые будут переданы на RPC-сервер
     */
    public function notify($method, $params = [])
    {
        try {
            $this->send(new Notify($method, $params));
        } catch (\Exception $e) {

        }
    }

    /**
     * Отправка запроса на сервер JSON-RPC 2.0
     *
     * @param Request|Notify|\JsonSerializable $request Сериализуемый объект запроса или уведомления
     * @return Response
     * @throws CurlException Если возникла ошибка cURL во время выполнения запроса
     */
    public function send(\JsonSerializable $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, $this->curl_opts + [
            CURLOPT_URL        => $this->url,
            CURLOPT_POSTFIELDS => json_encode($request),
        ]);

        $response   = curl_exec($curl);
        $error_code = curl_errno($curl);
        $error_msg  = curl_error($curl);

        curl_close($curl);

        if ( ! empty($error_code)) {
            throw new CurlException($error_msg, $error_code);
        }

        return $response;
    }

}