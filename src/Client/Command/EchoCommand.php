<?php declare(strict_types=1);
/*
 * This file is part of the grpc-php-service-example project.
 *
 * (c) 2018 Martin Ohmann <martin@mohmann.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Client\Command;

use App\Client\Grpc\GrpcClientFactory;
use App\GrpcStubs\EchoClient;
use App\GrpcStubs\EchoReply;
use App\GrpcStubs\EchoMessage;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EchoCommand extends AbstractGrpcCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('grpc:echo')
            ->addArgument('message', InputArgument::REQUIRED, 'The message that should be sent')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EchoClient $client */
        $client = $this->createGrpcClient(EchoClient::class);

        $message = new EchoMessage();
        $message->setMessage($input->getArgument('message'));

        /** @var EchoReply $reply */
        list($reply, $status) = $client->echo($message)->wait();

        $output->writeln(\sprintf('gRPC reply: %s', $reply->getMessage()));
        $output->writeln(\sprintf('Status code: %d', $status->code));
    }
}
