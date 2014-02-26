<?php

require_once __DIR__ . '/../vendor/autoload.php';

use JsonRPC\Client;

$client = new Client('http://127.0.0.1/rpc');
$client->notify('example.notify');

echo 'Notify sended' . PHP_EOL;