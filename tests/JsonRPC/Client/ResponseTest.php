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

        $this->assertNotEmpty($response->result);
        $this->assertNotEmpty($response->result->foo);
        $this->assertEquals($response->result->foo, 'bar');

        $this->assertNotEmpty($response->id);
        $this->assertEquals($response->id, 100);
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

}