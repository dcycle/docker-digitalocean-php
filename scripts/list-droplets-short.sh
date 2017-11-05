#!/bin/bash
#
# List droplets with their name, id, ip
# Usage:
#
# ./scripts/list-droplets-short.sh
#   List droplets for the default account defined in
#   ~/.digitalocean-php/token.env.
#
# ./scripts/list-droplets-short.sh -aclient-b
#   List droplets for the account defined in
#   ~/.digitalocean-php/cilent-b.env.
#

set -e

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
source "$DIR"/lib/env-file.source.sh

docker run --env-file "$ENVFILE" dcycle/digitalocean-php /bin/bash -c "php /scripts/list-droplets-short.php"
