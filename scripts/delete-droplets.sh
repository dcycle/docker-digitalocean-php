#!/bin/bash
#
# Delete droplets based on their name, id, ip
# Usage:
#
# ./scripts/delete-droplets.sh name /^droplet-name$/
#   Deletes droplet with name droplet-name in the account referenced by
#   by information in the file ~/.digitalocean-php/token.env.
#
# ./scripts/delete-droplets.sh ip /^1.2.3.4$/
#   Deletes droplet with ip 1.2.3.4 in the account referenced by
#   by information in the file ~/.digitalocean-php/token.env.
#
# ./scripts/delete-droplets.sh -aclient-b name /^droplet-/
#   Deletes ALL droplets with name beginning with droplet- using information
#   defined in ~/.digitalocean-php/client-b.env.
#

set -e

source ./scripts/lib/env-file.source.sh

docker run --env-file "$ENVFILE" dcycle/digitalocean-php /bin/bash -c "php /scripts/delete-droplets.php $1 $2"
