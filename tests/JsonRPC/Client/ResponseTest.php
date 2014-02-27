<?php

namespace JsonRPC\Tests\Client;

use JsonRPC\Client\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    public function testInstance()
    {
        $this->assertTrue(class_exists('\\JsonRPC\\Client\\Response'));
    }

    public function testSuccessResponse()
    {
        $response = new Response('{"jsonrpc": "2.0", "result": {"foo": "bar"}, "id": 100}');

        $this->assertNotEmpty($response->foo);
        $this->assertEquals($response->foo, 'bar');
    }

    /**
     * @expectedException \JsonRPC\Exception\RPC
     * @expectedExceptionCode \JsonRPC\Exception\RPC::CODE_METHOD_NOT_FOUND
     * @expectedExceptionMessage Method not found
     */
    public function testErrorResponse()
    {
        new Response('{"jsonrpc": "2.0", "error": {"code": -32601, "message": "Method not found"}, "id": 1}');
    }

    /**
     * @expectedException \JsonRPC\Exception\Json
     * @expectedExceptionCode JSON_ERROR_SYNTAX
     * @expectedExceptionMessage JSON parse error
     */
    public function testInvalidResponse()
    {
        new Response('invalid json');
    }

    public function testGetId()
    {
        $response = new Response('{"jsonrpc": "2.0", "result": {"foo": "bar"}, "id": 100}');
        
        $this->assertEquals($response->getId(), 100);
    }

    public function testGetResult()
    {
        $data     = ['jsonrpc' => '2.0', 'result' => (object) ['foo' => 'bar']];
        $response = new Response(json_encode($data));
        
        $this->assertEquals($response->getResult(), $data['result']);
    }

}