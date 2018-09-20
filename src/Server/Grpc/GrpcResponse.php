<?php declare(strict_types=1);
/*
 * This file is part of the grpc-php-service-example project.
 *
 * (c) 2018 Martin Ohmann <martin@mohmann.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Server\Grpc;

use Google\Protobuf\Internal\Message;
use Symfony\Component\HttpFoundation\Response;

class GrpcResponse extends Response
{
    /**
     * @param mixed $content
     */
    public function __construct($content)
    {
        parent::__construct($content);

        $this->headers->set('Content-Type', 'application/grpc');
    }

    /**
     * {@inheritDoc}
     */
    public function setContent($content): GrpcResponse
    {
        if ($content instanceof Message) {
            $content = $content->serializeToString();
        }

        return parent::setContent($content);
    }
}
