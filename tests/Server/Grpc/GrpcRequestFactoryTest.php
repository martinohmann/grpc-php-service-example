<?php
/*
 * This file is part of the grpc-php-service-example project.
 *
 * (c) 2018 Martin Ohmann <martin@mohmann.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Server\Grpc;

use App\GrpcStubs\EchoMessage;
use App\Server\Grpc\GrpcRequestFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

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
