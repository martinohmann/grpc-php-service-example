<?php declare(strict_types=1);

namespace App\Controller\Grpc\HelloWorld;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\GrpcStubs\HelloWorld\HelloRequest;
use App\GrpcStubs\HelloWorld\HelloReply;
use App\Grpc\GrpcResponse;
use App\Grpc\GrpcRequestFactory;
use Google\Protobuf\Internal\Message;

/**
 * @Route("/helloworld.Greeter", methods={"POST"})
 */
class GreeterController extends Controller
{
    /**
     * @Route("/SayHello")
     *
     * @param HelloRequest $request
     * @return GrpcResponse
     */
    public function sayHello(HelloRequest $request): GrpcResponse
    {
        $reply = new HelloReply();

        $reply->setMessage(
            \sprintf(
                'Hello %s',
                $request->getName()
            )
        );

        return new GrpcResponse($reply);
    }
}
