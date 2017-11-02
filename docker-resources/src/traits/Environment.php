<?php

namespace digitalocean_php\traits;

use \DigitalOceanV2\Adapter\BuzzAdapter;
use \DigitalOceanV2\DigitalOceanV2;

/**
 * Wrapper around elements external to the application logic.
 */
trait Environment {

  /**
   * Gets an argument from the command line.
   *
   * @param array $argv
   *   The $argv variable from the file which was first called.
   * @param int $num
   *   The argument number, keeping in mind that number 0 is the name
   *   of the script.
   * @param string $default
   *   A default value if the argument is not set.
   * @param bool $required
   *   Whether the argument is required or not. If so, the default value
   *   is ignored.
   *
   * @return string
   *   The value of the arg.
   *
   * @throws Exception
   */
  public function arg(array $argv, int $num, string $default, bool $required = FALSE) : string {
    $return = $argv[$num];
    if (!$return && $required) {
      throw new \Exception('Argument ' . $num . ' is required.');
    }
    return $return ?: $default;
  }

  /**
   * Mockable wrapper around getenv(), with exception handling.
   *
   * @param string $name
   *   Name of the environment variable.
   * @param bool $required
   *   Whether the environment variable is required or not.
   * @param string $default
   *   A default value if not required.
   *
   * @return string
   *   The value of the environment variable.
   *
   * @throws \Exception
   */
  public function getEnv(string $name, bool $required = TRUE, string $default = '') : string {
    $return = getenv($name);
    if (!$return && $required) {
      throw new \Exception('Please make sure the environment variable ' . $name . ' is set.');
    }
    $return = (string) $return;
    return $return ?: $default;
  }

  /**
   * Return the DigitalOcean droplet API class.
   *
   * This is added in the Dockerfile, and the code lives at
   * https://github.com/toin0u/DigitalOceanV2.
   */
  public function dropletApi() {
    // Create an adapter with your access token which can be
    // generated at https://cloud.digitalocean.com/settings/applications.
    $adapter = new BuzzAdapter(getenv('TOKEN'));

    // Create a digital ocean object with the previous adapter.
    $digitalocean = new DigitalOceanV2($adapter);

    // Return the droplet api.
    return $digitalocean->droplet();
  }

  /**
   * Mockable wrapper preg_match(), handles errors with an exception.
   */
  public function pregMatch($pattern, $subject) {
    $return = @preg_match($pattern, $subject);
    if ($return === FALSE) {
      throw new \Exception($pattern . ' is not an acceptable preg_match() pattern.');
    }
    return $return;
  }

  /**
   * Mockable wrapper around print_r().
   */
  public function printR($string) {
    print_r($string);
  }

  /**
   * Mockable wrapper around scandir(), with exception handling.
   *
   * @param string $directory
   *   Path to a directory.
   *
   * @return array
   *   List of files.
   *
   * @throws \Exception
   */
  public function scanDir(string $directory) : array {
    $return = @scandir($directory);
    if (!is_array($return)) {
      throw new \Exception('Could not scan directory ' . $directory);
    }
    return $return;
  }

  /**
   * Mockable wrapper around print().
   */
  public function print($string) {
    print($string);
  }

}
