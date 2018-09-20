<?php

use App\Grpc\HelloWorld\HelloRequest;
use App\Grpc\HelloWorld\HelloReply;

require __DIR__.'/../vendor/autoload.php';

$body = file_get_contents('php://input');

$request = new HelloRequest();
$request->mergeFromString($body);

$response = new HelloReply();
$response->setMessage(sprintf("Hello %s %s", $request->getName(), json_encode($_SERVER)));

header('Content-Type: application/grpc');

print($response->serializeToString());
