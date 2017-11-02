<?php

/**
 * @file
 * Class autoloader for normal use.
 */

require 'vendor/autoload.php';

spl_autoload_register(function ($class) {
  if (substr($class, 0, strlen('digitalocean_php\\')) == 'digitalocean_php\\') {
    $class = preg_replace('/^digitalocean_php\\\\/', '', $class);
    $path = 'src/' . str_replace('\\', '/', $class) . '.php';
    require_once $path;
  }
});
