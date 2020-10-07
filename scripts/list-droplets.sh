#!/bin/bash
#
# List droplet full information.
# Usage:
#
# ./scripts/list-droplets.sh
#   List droplets for the default account defined in
#   ~/.digitalocean-php/token.env.
#
# ./scripts/list-droplets.sh -aclient-b
#   List droplets for the account defined in
#   ~/.digitalocean-php/cilent-b.env.
#

set -e

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
source "$DIR"/lib/env-file.source.sh

docker run --rm --env-file "$ENVFILE" dcycle/digitalocean-php /bin/bash -c "php /scripts/list-droplets.php"
