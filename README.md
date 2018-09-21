grpc-php-service-example
========================

[![Build Status](https://travis-ci.org/martinohmann/grpc-php-service-example.svg?branch=master)](https://travis-ci.org/martinohmann/grpc-php-service-example)
[![Coverage Status](https://coveralls.io/repos/github/martinohmann/grpc-php-service-example/badge.svg)](https://coveralls.io/github/martinohmann/grpc-php-service-example)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![PHP 7.1+](https://img.shields.io/badge/php-7.1%2B-blue.svg)](https://github.com/mohmann/grpc-php-service-example)

This is an example service for both PHP gRPC server and client implementations.

It uses [grpc-fastcgi-proxy](https://github.com/bakins/grpc-fastcgi-proxy) to
provide an example PHP gRPC server implementation which is not feature complete.

The main goal of the project is to get some experience with gRPC in PHP projects.

Usage
-----

Docker and docker-compose are required to run the client, server and grpc-fastcgi-proxy.

```
docker-compose up --build
docker-compose exec client composer install
docker-compose exec client bin/console grpc:echo 'some message'
```

Structure
---------

The example clients and servers are bundled together in this project for the sake of
demonstration purposes and simplicity while playing around with them.

Client code is located below `src/Client` while the server code resides in `src/Server`.

Development / Testing
---------------------

The `.proto` files reside in `protos/`. Edit them to your needs and run

```
make proto
```

to generate the PHP stubs. Output will be written into the `generated/` directory.

Refer to the `Makefile` for other helpful commands, e.g.:

```
make stan
make test
make inf
```

Known Limitations
-----------------

- The server only supports UnaryUnary gRPC calls. Streaming calls will not work as intended.

License
-------

grpc-php-service-example is released under the MIT License. See the bundled LICENSE file for details.

Acknowledgements
----------------

- [Brian Akins](https://github.com/bakins) for his experimental [grpc-fastcgi-proxy](https://github.com/bakins/grpc-fastcgi-proxy)
