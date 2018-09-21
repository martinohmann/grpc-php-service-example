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
use App\GrpcStubs\Math\FibArgs;
use App\GrpcStubs\Math\MathClient;
use App\GrpcStubs\Math\Num;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FibCommand extends AbstractGrpcCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('grpc:math:fib')
            ->addArgument('limit', InputArgument::REQUIRED, 'Fibonacci limit')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var MathClient $client */
        $client = $this->createGrpcClient(MathClient::class);

        $fibArgs = new FibArgs();
        $fibArgs->setLimit($input->getArgument('limit'));

        $call = $client->Fib($fibArgs);

        $results = iterator_to_array($call->responses());

        foreach ($results as $num) {
            $output->writeln($num->getNum());
        }
    }
}
