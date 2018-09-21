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
use App\Server\Grpc\GrpcMessageFactory;
use App\Server\Grpc\GrpcMessageValueResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class GrpcMessageValueResolverTest extends TestCase
{
    /**
     * @var GrpcMessageFactory
     */
    private $messageFactory;

    /**
     * @var GrpcMessageValueResolver
     */
    private $resolver;

    public function setUp()
    {
        $this->messageFactory = \Phake::mock(GrpcMessageFactory::class);
        $this->resolver = new GrpcMessageValueResolver($this->messageFactory);
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

        \Phake::when($this->messageFactory)
            ->create(EchoMessage::class, $request)
            ->thenReturn(new EchoMessage());

        $resolved = iterator_to_array($this->resolver->resolve($request, $metadata));

        $this->assertInstanceOf(EchoMessage::class, $resolved[0]);

        \Phake::verify($this->messageFactory)
            ->create(EchoMessage::class, $request);
    }
}
