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

    docker run --rm --env-file ~/.digitalocean-php/token.env -v /path/to/my/scripts:/my-scripts dcycle/digitalocean-php /bin/bash -c 'php /my-scripts/list-droplets.php'

Multiple environment files
-----

If you only have one Digital Ocean account, put all information related to the account in ~/.digitalocean-php/token.env, and use the scripts like this:

    ./scripts/new-droplet.sh throwaway-droplet
    ./scripts/delete-droplets name /^throwaway-droplet$/

If you have multiple accounts or usages, duplicate the ~/.digitalocean-php/token.env and add account information into the new file, for example ~/.digitalocean-php/some-other-account.env, then use:

    ./scripts/new-droplet.sh -asome-other-account throwaway-droplet
    ./scripts/delete-droplets -asome-other-account name /^throwaway-droplet$/

Troubleshooting
-----

### Public vs private IP addresses

Before September 2020, `./scripts/new-droplet.sh` would always return the public IP address of the new server, for example:

    PUBLIC_IP=$(./scripts/new-droplet.sh hello-world)

Due to a possible change in the API, `./scripts/new-droplet.sh` no longer returns the public IP. If you have scripts which try to obtain the public IP this manner, you need to change them to something like this hacky and ugly command:

    PRIVATE_IP=$(./scripts/new-droplet.sh hello-world)
    PUBLIC_IP=$(./scripts/list-droplets.sh |grep 10.132.0.3 --after-context=10|tail -1|cut -b 44-)

### Changing image names

Sometimes if you are creating a VM from a specific image, for example if ~/.digitalocean-php/token.env contains:

    ...
    IMAGE=docker-18-04
    ...

DigitalOcean sometimes changes the image machine names (called slugs). To get an updated list of available images, you can run (in this example we're interested in application type images):

    source ~/.digitalocean-php/token.env
    curl -H "Authorization: Bearer $TOKEN" -X GET "https://api.digitalocean.com/v2/images?type=application"
