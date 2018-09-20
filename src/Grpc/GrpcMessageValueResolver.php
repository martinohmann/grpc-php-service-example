<?php declare(strict_types=1);

namespace App\Grpc;

use Google\Protobuf\Internal\Message;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class GrpcMessageValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var GrpcRequestFactory
     */
    private $factory;

    /**
     * @param GrpcRequestFactory $factory
     */
    public function __construct(GrpcRequestFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return is_subclass_of($argument->getType(), Message::class);
    }

    /**
     * {@inheritDoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield $this->factory->create($argument->getType(), $request);
    }
}
