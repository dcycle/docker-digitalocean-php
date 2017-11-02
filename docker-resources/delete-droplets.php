<?php

/**
 * @file
 * Delete a droplet.
 */

require_once 'autoload.php';

use digitalocean_php\App;

App::instance()->deleteDroplets(App::instance()->arg($argv, 1, '', TRUE), App::instance()->arg($argv, 2, '', TRUE));
