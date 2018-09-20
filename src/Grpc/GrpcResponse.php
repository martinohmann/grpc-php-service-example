<?php declare(strict_types=1);

namespace App\Grpc;

use Google\Protobuf\Internal\Message;
use Symfony\Component\HttpFoundation\Response;

class GrpcResponse extends Response
{
    /**
     * @param Message $message
     */
    public function __construct($content)
    {
        parent::__construct($content);

        $this->headers->set('Content-Type', 'application/grpc');
    }

    /**
     * {@inheritDoc}
     */
    public function setContent($content): Response
    {
        if ($content instanceof Message) {
            $content = $content->serializeToString();
        }

        return parent::setContent($content);
    }
}
