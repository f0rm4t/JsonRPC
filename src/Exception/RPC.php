<?php

namespace JsonRPC\Exception;

class RPC extends \Exception
{

    /** @var int Invalid JSON was received by the server. An error occurred on the server while parsing the JSON text. */
    const CODE_PARSE_ERROR = -32700;
    /** @var int The JSON sent is not a valid Request object. */
    const CODE_INVALID_REQUEST = -32600;
    /** @var int The method does not exist / is not available. */
    const CODE_METHOD_NOT_FOUND = -32601;
    /** @var int Invalid method parameter(s). */
    const CODE_INVALID_PARAMETERS = -32602;
    /** @var int Internal JSON-RPC error. */
    const CODE_INTERNAL_ERROR = -32603;

}