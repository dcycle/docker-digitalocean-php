Docker wrapper around [Digital Ocean PHP API](https://github.com/toin0u/DigitalOceanV2).

Usage
-----

**You are strongly encouraged to create a "throwaway" Digital Ocean account to avoid accidentally deleting an important droplet**. This collection of scripts is designed to create a droplet to perform some task, then destroy it; and to periodically destroy all droplets to avoid having dangling droplets.

You do not need to download this code; you only need Docker to run this code.

    mkdir ~/.digitalocean-php
    echo 'TOKEN=my-token' >> ~/.digitalocean-php/token.env
    docker run --env-file ~/.digitalocean-php/token.env  dcycle/digitalocean-php /bin/bash -c 'php /scripts/list-droplets.php'

With your own scripts:

    docker run --env-file ~/.digitalocean-php/token.env -v /path/to/my/scripts:/my-scripts dcycle/digitalocean-php /bin/bash -c 'php /my-scripts/list-droplets.php'
