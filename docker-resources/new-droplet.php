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
$created = $droplet->create('my-droplet', 'nyc3', '1gb', 'docker-16-04', FALSE, FALSE, FALSE, array(getenv('SSH_FINGERPRINT')));

$id = $created->id;

$droplets = $droplet->getAll();
for ($i = 0; $i < 15; $i++) {
  sleep(1);
  foreach ($droplets as $droplet) {
    print_r('AAA');
    print_r($droplet);
    print_r('BBB');
    print_r($droplet->networks);
    print_r('CCC');
    print_r($droplet->networks[0]);
    print_r('DDD');
    print_r($droplet->networks[0]->ipAddress);
    print_r('EEE');
    if ($droplet->id == $id) {
      if (isset($droplet->networks[0]->ipAddress)) {
        print_r($droplet->networks[0]->ipAddress);
        break 2;
      }
      else {
        print_r('object not available');
      }
    }
  }
}
