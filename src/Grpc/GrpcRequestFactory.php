<?php declare(strict_types=1);

namespace App\Grpc;

use Google\Protobuf\Internal\Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Exception\ClassNotFoundException;

class GrpcRequestFactory
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
