#!/bin/bash
#
# Run unit tests.
#

docker run --rm -v "$(pwd)":/app phpunit/phpunit \
  --group digitalocean_php
