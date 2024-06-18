#!/bin/bash
set -e
go mod tidy
rm -f main
GOOS=linux GOARCH=amd64 CGO_ENABLED=0 go build -o main main.go