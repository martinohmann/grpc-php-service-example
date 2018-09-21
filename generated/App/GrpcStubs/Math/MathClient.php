<?php
// GENERATED CODE -- DO NOT EDIT!

namespace App\GrpcStubs\Math;

/**
 */
class MathClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Div divides DivArgs.dividend by DivArgs.divisor and returns the quotient
     * and remainder.
     * @param \App\GrpcStubs\Math\DivArgs $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Div(\App\GrpcStubs\Math\DivArgs $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/math.Math/Div',
        $argument,
        ['\App\GrpcStubs\Math\DivReply', 'decode'],
        $metadata, $options);
    }

    /**
     * DivMany accepts an arbitrary number of division args from the client stream
     * and sends back the results in the reply stream.  The stream continues until
     * the client closes its end; the server does the same after sending all the
     * replies.  The stream ends immediately if either end aborts.
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DivMany($metadata = [], $options = []) {
        return $this->_bidiRequest('/math.Math/DivMany',
        ['\App\GrpcStubs\Math\DivReply','decode'],
        $metadata, $options);
    }

    /**
     * Fib generates numbers in the Fibonacci sequence.  If FibArgs.limit > 0, Fib
     * generates up to limit numbers; otherwise it continues until the call is
     * canceled.  Unlike Fib above, Fib has no final FibReply.
     * @param \App\GrpcStubs\Math\FibArgs $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Fib(\App\GrpcStubs\Math\FibArgs $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/math.Math/Fib',
        $argument,
        ['\App\GrpcStubs\Math\Num', 'decode'],
        $metadata, $options);
    }

    /**
     * Sum sums a stream of numbers, returning the final result once the stream
     * is closed.
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Sum($metadata = [], $options = []) {
        return $this->_clientStreamRequest('/math.Math/Sum',
        ['\App\GrpcStubs\Math\Num','decode'],
        $metadata, $options);
    }

}
