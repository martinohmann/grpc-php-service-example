<?php
// GENERATED CODE -- DO NOT EDIT!

namespace App\GrpcStubs;

/**
 */
class EchoClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \App\GrpcStubs\EchoMessage $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function echo(\App\GrpcStubs\EchoMessage $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/Echo/echo',
        $argument,
        ['\App\GrpcStubs\EchoMessage', 'decode'],
        $metadata, $options);
    }

}
