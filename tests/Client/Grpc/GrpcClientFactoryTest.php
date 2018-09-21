<?php
/*
 * This file is part of the grpc-php-service-example project.
 *
 * (c) 2018 Martin Ohmann <martin@mohmann.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Client\Grpc;

use App\Client\Grpc\GrpcClientFactory;
use App\GrpcStubs\EchoClient;
use PHPUnit\Framework\TestCase;

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
