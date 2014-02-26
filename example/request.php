<?php

require_once __DIR__ . '/../vendor/autoload.php';

use JsonRPC\Client;
use JsonRPC\Exception\RPC as RPCException;
use JsonRPC\Exception\Json as JsonException;
use JsonRPC\Exception\Curl as CurlException;

try {
    $client   = new Client('http://127.0.0.1/rpc');
    $response = $client->request('example.method', ['foo' => 'bar'], 100);

    printf('result: %s' . PHP_EOL, $response->result);
} catch (RPCException $e) {
    printf('RPC Execption: %d - %s' . PHP_EOL, $e->getCode(), $e->getMessage());
} catch (JsonException $e) {
    printf('JSON Exception %d - %s' . PHP_EOL, $e->getCode(), $e->getMessage());
} catch (CurlException $e) {
    printf('cURL Exception %d - %s' . PHP_EOL, $e->getCode(), $e->getMessage());
}