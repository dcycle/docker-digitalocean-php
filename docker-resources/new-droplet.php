<?php

require 'vendor/autoload.php';

use DigitalOceanV2\Adapter\BuzzAdapter;
use DigitalOceanV2\DigitalOceanV2;

// create an adapter with your access token which can be
// generated at https://cloud.digitalocean.com/settings/applications
$adapter = new BuzzAdapter(getenv('TOKEN'));

// create a digital ocean object with the previous adapter
$digitalocean = new DigitalOceanV2($adapter);

// return the droplet api
$droplet = $digitalocean->droplet();

// return a collection of Droplet entity
$created = $droplet->create('server-' . rand(1000000, 9999999), 'nyc3', '1gb', 'docker-16-04', FALSE, FALSE, FALSE, array(getenv('SSH_FINGERPRINT')));

$id = $created->id;

for ($i = 0; $i < 90; $i++) {
  sleep(5);
  $droplets = $droplet->getAll();
  foreach ($droplets as $droplet) {
    if ($droplet->id == $id) {
      if (isset($droplet->networks[0]->ipAddress)) {
        print_r($droplet->networks[0]->ipAddress);
        break 2;
      }
    }
  }
}
