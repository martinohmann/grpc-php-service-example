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
use App\Client\Grpc\GrpcClientFactory;
use App\GrpcStubs\Math\MathClient;
use App\GrpcStubs\Math\Num;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SumCommand extends AbstractGrpcCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('grpc:math:sum')
            ->addArgument('limit', InputArgument::REQUIRED, 'Sum limit')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var MathClient $client */
        $client = $this->createGrpcClient(MathClient::class);

        $limit = (int) $input->getArgument('limit');

        $call = $client->Sum();

        for ($i = 1; $i <= $limit; ++$i) {
            $num = new Num();
            $num->setNum($i);
            $call->write($num);
        }

        /** @var Num $reply */
        list($reply, $status) = $call->wait();

        $output->writeln(
            \sprintf(
                'gRPC reply: sum: %d',
                $reply->getNum()
            )
        );
        $output->writeln(\sprintf('Status code: %d', $status->code));
    }
}
