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

}
