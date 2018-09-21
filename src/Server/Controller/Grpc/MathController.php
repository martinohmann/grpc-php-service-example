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

use App\GrpcStubs\Math\DivArgs;
use App\GrpcStubs\Math\DivReply;
use App\Server\Grpc\GrpcResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/math.Math", methods={"POST"})
 */
class MathController extends Controller
{
    /**
     * @Route("/Div")
     *
     * @param DivArgs $divArgs
     * @return GrpcResponse
     */
    public function div(DivArgs $divArgs): GrpcResponse
    {
        $reply = new DivReply();

        $quotient = intdiv((int) $divArgs->getDividend(), (int) $divArgs->getDivisor());
        $remainder = $divArgs->getDividend() % $divArgs->getDivisor();

        $reply->setQuotient($quotient);
        $reply->setRemainder($remainder);

        return new GrpcResponse($reply);
    }
}
