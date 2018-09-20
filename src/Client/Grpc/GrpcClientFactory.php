<?php declare(strict_types=1);
/*
 * This file is part of the grpc-php-service-example project.
 *
 * (c) 2018 Martin Ohmann <martin@mohmann.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Client\Grpc;

use Grpc\BaseStub;
use Grpc\ChannelCredentials;

class GrpcClientFactory
{
    /**
     * @param string $className
     * @param string $address
     * @return BaseStub
     */
    public function create(string $className, string $address): BaseStub
    {
        if (!\is_subclass_of($className, BaseStub::class)) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'Class "%s" is no subclass of "%s", cannot create gRPC client',
                    $className,
                    BaseStub::class
                )
            );
        }
        
        $client = new $className($address, [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);

        return $client;
    }
}
