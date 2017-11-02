Docker wrapper around [Digital Ocean PHP API](https://github.com/toin0u/DigitalOceanV2).

[![CircleCI](https://circleci.com/gh/dcycle/docker-digitalocean-php.svg?style=svg)](https://circleci.com/gh/dcycle/docker-digitalocean-php)

Usage
-----

**You are strongly encouraged to create a "throwaway" Digital Ocean account to avoid accidentally deleting an important droplet**. This collection of scripts is designed to create a droplet to perform some task, then destroy it; and to periodically destroy all droplets to avoid having dangling droplets.

You do not need to download this code; you only need Docker to run this code.

    mkdir ~/.digitalocean-php
    echo 'TOKEN=my-token' >> ~/.digitalocean-php/token.env
    echo 'SSH_FINGERPRINT=aa:aa:aa:aa:aa:aa:aa:aa:aa:aa:aa:aa:aa:aa:aa:aa' >> ~/.digitalocean-php/token.env
    ./scripts/list-droplets.sh

(The SSH fingerprint is the fingerprint of an SSH key which you added to your DigitalOcean account and which you would like to use to access your new droplets)

With your own scripts:

    docker run --env-file ~/.digitalocean-php/token.env -v /path/to/my/scripts:/my-scripts dcycle/digitalocean-php /bin/bash -c 'php /my-scripts/list-droplets.php'
