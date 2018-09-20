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
use App\GrpcStubs\EchoRequest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EchoCommand extends Command
{
    /**
     * @var GrpcClientFactory
     */
    private $clientFactory;

    /**
     * @param GrpcClientFactory $clientFactory
     */
    public function __construct(GrpcClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('grpc:echo')
            ->addOption('address', 'a', InputOption::VALUE_REQUIRED, 'gRPC server address', 'localhost:8080')
            ->addArgument('message', InputArgument::REQUIRED, 'The message that should be sent')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $address = $input->getOption('address');

        /** @var EchoClient $client */
        $client = $this->clientFactory->create(EchoClient::class, $address);

        $request = new EchoRequest();
        $request->setMessage($input->getArgument('message'));

        /** @var EchoReply $reply */
        list($reply, $status) = $client->echo($request)->wait();

        $output->writeln(\sprintf('gRPC reply: %s', $reply->getMessage()));
        $output->writeln(\sprintf('Status code: %d', $status->code));
    }
}
