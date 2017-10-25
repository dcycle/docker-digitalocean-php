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
$droplets = $droplet->getAll();

$return = array();

foreach ($droplets as $droplet) {
  $return[$droplet->id] = $droplet->name;
}

print_r($return);
