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

class GrpcMessageFactory
{
    /**
     * @param string $className
     * @param Request $request
     * @return Message
     */
    public function create(string $className, Request $request): Message
    {
        if (!\is_subclass_of($className, Message::class)) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'Class "%s" is no subclass of "%s", cannot create gRPC request message',
                    $className,
                    Message::class
                )
            );
        }

        $grpcRequest = new $className();
        $grpcRequest->mergeFromString($request->getContent());

        return $grpcRequest;
    }
}
