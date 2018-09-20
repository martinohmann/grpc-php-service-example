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

use App\GrpcStubs\EchoReply;
use App\GrpcStubs\EchoRequest;
use App\Server\Grpc\GrpcResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Echo", methods={"POST"})
 */
class EchoController extends Controller
{
    /**
     * @Route("/echo")
     *
     * @param EchoRequest $request
     * @return GrpcResponse
     */
    public function echo(EchoRequest $request): GrpcResponse
    {
        $reply = new EchoReply();
        $reply->setMessage($request->getMessage());

        return new GrpcResponse($reply);
    }
}