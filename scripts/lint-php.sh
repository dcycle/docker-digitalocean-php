#!/bin/bash
#
# Lint php files.
#

docker run --rm -v "$(pwd)":/code dcycle/php-lint \
  --standard=DrupalPractice /code
docker run --rm -v "$(pwd)":/code dcycle/php-lint \
  --standard=Drupal /code
