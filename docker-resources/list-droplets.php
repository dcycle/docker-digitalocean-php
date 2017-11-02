<?php

/**
 * @file
 * Example entrypoint for our application.
 */

require_once 'autoload.php';

use digitalocean_php\App;

App::instance()->printR(App::instance()->listDroplets(App::instance()->arg($argv, 1, '*'), App::instance()->arg($argv, 2, '*')));
