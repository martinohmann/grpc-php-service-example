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
use App\Server\Grpc\GrpcMessageValueResolver;
use App\Server\Grpc\GrpcRequestFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class GrpcMessageValueResolverTest extends TestCase
{
    /**
     * @var GrpcRequestFactory
     */
    private $requestFactory;

    /**
     * @var GrpcMessageValueResolver
     */
    private $resolver;

    public function setUp()
    {
        $this->requestFactory = \Phake::mock(GrpcRequestFactory::class);
        $this->resolver = new GrpcMessageValueResolver($this->requestFactory);
    }

    /**
     * @test
     */
    public function itSupportsSubclassesOfMessage()
    {
        $metadata = \Phake::mock(ArgumentMetadata::class);

        \Phake::when($metadata)
            ->getType()
            ->thenReturn(EchoMessage::class);

        $this->assertTrue($this->resolver->supports(new Request(), $metadata));
    }

    /**
     * @test
     */
    public function itDoesNotSupportOtherClasses()
    {
        $metadata = \Phake::mock(ArgumentMetadata::class);

        \Phake::when($metadata)
            ->getType()
            ->thenReturn(\stdClass::class);

        $this->assertFalse($this->resolver->supports(new Request(), $metadata));
    }

    /**
     * @test
     */
    public function itUsesRequestFactoryToCreateMessage()
    {
        $request = \Phake::mock(Request::class);
        $metadata = \Phake::mock(ArgumentMetadata::class);

        \Phake::when($metadata)
            ->getType()
            ->thenReturn(EchoMessage::class);

        \Phake::when($this->requestFactory)
            ->create(EchoMessage::class, $request)
            ->thenReturn(new EchoMessage());

        $resolved = iterator_to_array($this->resolver->resolve($request, $metadata));

        $this->assertInstanceOf(EchoMessage::class, $resolved[0]);

        \Phake::verify($this->requestFactory)
            ->create(EchoMessage::class, $request);
    }
}
