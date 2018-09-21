FROM php:7.2-alpine

RUN set -xe && \
    apk update && \
    apk add --no-cache autoconf build-base gcc wget git zlib-dev

RUN set -xe && \
    pecl install grpc-1.15.0 && \
    pecl install protobuf && \
    echo 'extension=grpc.so' > /usr/local/etc/php/conf.d/grpc.ini && \
    echo 'extension=protobuf.so' > /usr/local/etc/php/conf.d/protobuf.ini

RUN set -xe && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer global require "hirak/prestissimo:^0.3"
