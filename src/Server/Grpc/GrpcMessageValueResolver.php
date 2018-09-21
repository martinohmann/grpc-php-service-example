<?php declare(strict_types=1);
/*
 * This file is part of the grpc-php-service-example project.
 *
 * (c) 2018 Martin Ohmann <martin@mohmann.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Server\Grpc;

use Google\Protobuf\Internal\Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class GrpcMessageValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var GrpcMessageFactory
     */
    private $factory;

    /**
     * @param GrpcMessageFactory $factory
     */
    public function __construct(GrpcMessageFactory $factory)
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
