<?php

/**
 * @file
 * Example entrypoint for our application.
 */

require_once 'autoload.php';

use digitalocean_php\App;

App::instance()->printR(App::instance()->newDroplet(App::instance()->arg($argv, 1, '', TRUE)));
