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
use Grpc\BaseStub;
use Symfony\Component\Console\Command\Command;

abstract class AbstractGrpcCommand extends Command
{
    /**
     * @var GrpcClientFactory
     */
    private $grpcClientFactory;

    /**
     * @param GrpcClientFactory $grpcClientFactory
     */
    public function __construct(GrpcClientFactory $grpcClientFactory)
    {
        $this->grpcClientFactory = $grpcClientFactory;

        parent::__construct();
    }

    /**
     * @param string $className
     * @return BaseStub
     */
    protected function createGrpcClient(string $className): BaseStub
    {
        return $this->grpcClientFactory->create($className);
    }
}
