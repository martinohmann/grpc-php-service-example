<?php declare(strict_types=1);
/*
 * This file is part of the grpc-php-service-example project.
 *
 * (c) 2018 Martin Ohmann <martin@mohmann.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Server\Controller\Grpc;

use App\GrpcStubs\HelloWorld\HelloReply;
use App\GrpcStubs\HelloWorld\HelloRequest;
use App\Server\Grpc\GrpcResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/helloworld.Greeter", methods={"POST"})
 */
class GreeterController extends Controller
{
    /**
     * @Route("/sayHello")
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
