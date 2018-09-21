<?php

namespace App\Tests\Client\Grpc;

use PHPUnit\Framework\TestCase;
use App\Client\Grpc\GrpcClientFactory;
use App\GrpcStubs\EchoClient;

class GrpcClientFactoryTest extends TestCase
{
    /**
     * @var GrpcClientFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new GrpcClientFactory('localhost:1337');
    }

    /**
     * @test
     */
    public function itCreatesClientFromClassName()
    {
        $client = $this->factory->create(EchoClient::class);

        $this->assertInstanceOf(EchoClient::class, $client);
        $this->assertSame('localhost:1337', $client->getTarget());
    }

    /**
     * @test
     */
    public function itOnlyCreatesClientsThatAreSubclassesOfBaseStub()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->factory->create(\stdClass::class);
    }
}
