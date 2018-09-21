<?php declare(strict_types=1);
/*
 * This file is part of the grpc-php-service-example project.
 *
 * (c) 2018 Martin Ohmann <martin@mohmann.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Client\Command\Math;

use App\Client\Command\AbstractGrpcCommand;
use App\GrpcStubs\Math\DivArgs;
use App\GrpcStubs\Math\DivReply;
use App\GrpcStubs\Math\MathClient;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DivCommand extends AbstractGrpcCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('grpc:math:div')
            ->addArgument('dividend', InputArgument::REQUIRED, 'Dividend')
            ->addArgument('divisor', InputArgument::REQUIRED, 'Divisor')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var MathClient $client */
        $client = $this->createGrpcClient(MathClient::class);

        $divArgs = new DivArgs();
        $divArgs->setDividend($input->getArgument('dividend'));
        $divArgs->setDivisor($input->getArgument('divisor'));

        /** @var DivReply $reply */
        list($reply, $status) = $client->Div($divArgs)->wait();

        $output->writeln(
            \sprintf(
                'gRPC reply: quotient: %d, remainder: %d',
                $reply->getQuotient(),
                $reply->getRemainder()
            )
        );
        $output->writeln(\sprintf('Status code: %d', $status->code));
    }
}
