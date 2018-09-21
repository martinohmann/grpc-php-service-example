<?php

namespace App\Tests\Server\Grpc;

use PHPUnit\Framework\TestCase;
use App\Server\Grpc\GrpcRequestFactory;
use App\Server\Grpc\GrpcMessageValueResolver;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use App\GrpcStubs\EchoMessage;
use Symfony\Component\HttpFoundation\Request;

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
