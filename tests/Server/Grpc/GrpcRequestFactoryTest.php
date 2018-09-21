<?php

namespace App\Tests\Server\Grpc;

use PHPUnit\Framework\TestCase;
use App\Server\Grpc\GrpcRequestFactory;
use Symfony\Component\HttpFoundation\Request;
use App\GrpcStubs\EchoMessage;

class GrpcRequestFactoryTest extends TestCase
{
    /**
     * @var GrpcRequestFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new GrpcRequestFactory();
    }

    /**
     * @test
     */
    public function itCreatesGrpcMessageFromClassNameAndRequest()
    {
        $echoRequest = new EchoMessage();
        $echoRequest->setMessage('foo');

        $request = \Phake::mock(Request::class);

        \Phake::when($request)
            ->getContent()
            ->thenReturn($echoRequest->serializeToString());

        $message = $this->factory->create(EchoMessage::class, $request);

        $this->assertInstanceOf(EchoMessage::class, $message);

        $this->assertSame('foo', $message->getMessage());
    }

    /**
     * @test
     */
    public function itOnlyCreatesClientsThatAreSubclassesOfMessage()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->factory->create(\stdClass::class, new Request());
    }
}
