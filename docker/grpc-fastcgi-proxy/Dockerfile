FROM golang:1.11-alpine

RUN set -xe && \
    apk add --no-cache git && \
    mkdir -p /go/src/github.com/bakins && \
    git clone https://github.com/bakins/grpc-fastcgi-proxy /go/src/github.com/bakins/grpc-fastcgi-proxy && \
    cd /go/src/github.com/bakins/grpc-fastcgi-proxy && \
    go build ./cmd/grpc-fastcgi-proxy && \
    mv grpc-fastcgi-proxy /usr/local/bin && \
    cd / && \
    rm -rf /go/src/github.com/bakins
