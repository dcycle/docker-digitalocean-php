#!/bin/bash
#
# Create a named droplet, keep in mind it is possible to have >1 droplet with
# the same name.
# Usage:
#
# ./scripts/new-droplet.sh my-droplet
#   Create new droplet named my-droplet for the default account defined in
#   ~/.digitalocean-php/token.env.
#
# ./scripts/new-droplet.sh -aclient-b my-droplet
#   Create nwe droplet named my-droplet for the account defined in
#   ~/.digitalocean-php/cilent-b.env.
#

set -e

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
source "$DIR"/lib/env-file.source.sh

docker run --rm --env-file "$ENVFILE" dcycle/digitalocean-php /bin/bash -c "php /scripts/new-droplet.php $1"
