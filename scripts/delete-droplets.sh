docker run --env-file ~/.digitalocean-php/token.env dcycle/digitalocean-php /bin/bash -c "php /scripts/delete-droplets.php $1 $2"
