<?php

namespace digitalocean_php;

use digitalocean_php\traits\Environment;
use digitalocean_php\traits\Singleton;

/**
 * Encapsulated code for the application.
 */
class App {

  use Environment;
  use Singleton;

  /**
   * Deletes droplets.
   *
   * @param string $param
   *   id, name, ip, or '*'. If '*', the pattern is ignored and all droplets
   *   are ignored.
   * @param string $pattern
   *   A grep pattern.
   *
   * @throws Exception
   */
  public function deleteDroplets(string $param, string $pattern) {
    $droplets = $this->listDroplets($param, $pattern);

    foreach ($droplets as $droplet) {
      $this->printR('Deleting droplet ' . $droplet->name . PHP_EOL);
      $this->dropletApi()->delete($droplet->id);
    }
  }

  /**
   * Lists droplets.
   *
   * @param string $param
   *   id, name, ip, or '*'. If '*', the pattern is ignored and all droplets
   *   are returned.
   * @param string $pattern
   *   A grep pattern.
   *
   * @return array
   *   A list of droplet objects.
   *
   * @throws Exception
   */
  public function listDroplets(string $param, string $pattern) : array {
    $all = $this->dropletApi()->getAll();
    if ($param == '*') {
      return $all;
    }
    $return = [];
    foreach ($all as $droplet) {
      switch ($param) {
        case 'id':
        case 'name':
          if ($this->pregMatch($pattern, $droplet->{$param})) {
            $return[] = $droplet;
          }
          break;

        case 'ip':
          if ($this->pregMatch($pattern, $droplet->networks[0]->ipAddress)) {
            $return[] = $droplet;
          }
          break;

        default:
          throw new \Exception('The parameter type should be id, name or ip, not ' . $param);
      }
    }
    return $return;
  }

  /**
   * Lists droplets in short form (id, name, ip).
   *
   * @param string $param
   *   id, name, ip, or '*'. If '*', the pattern is ignored and all droplets
   *   are returned.
   * @param string $pattern
   *   A grep pattern.
   *
   * @return array
   *   A list of droplet associative arrays with id, name, ip.
   *
   * @throws Exception
   */
  public function listDropletsShort(string $param, string $pattern) : array {
    $droplets = $this->listDroplets($param, $pattern);
    $return = [];
    foreach ($droplets as $droplet) {
      $return[] = [
        'id' => $droplet->id,
        'name' => $droplet->name,
        'first ip' => empty($droplet->networks[0]->ipAddress) ? 'n/a' : $droplet->networks[0]->ipAddress,
      ];
    }
    return $return;
  }

  public function newDroplet(string $name) : string {
    $dropletapi = $this->dropletApi();
    $created = $dropletapi->create($name,
      $this->getEnv('LOCATION', FALSE, 'nyc3'),
      $this->getEnv('SIZE', FALSE, '512mb'),
      $this->getEnv('IMAGE', FALSE, 'coreos-stable'),
      FALSE, FALSE, FALSE,
      array($this->getEnv('SSH_FINGERPRINT')), '', FALSE);

    $id = $created->id;

    for ($i = 0; $i < 90; $i++) {
      sleep(5);
      $droplets = $this->dropletApi()->getAll();
      foreach ($droplets as $droplet) {
        if ($droplet->id == $id) {
          if (isset($droplet->networks[0]->ipAddress)) {
            return $droplet->networks[0]->ipAddress;
          }
        }
      }
    }
    throw new \Exception('No IP address for container ' . $id . ' after 90 seconds.');
  }

  /**
   * Prints the square root of the number of files in a directory.
   *
   * This method is admittedly useless, but it is meant to demonstrate how
   * a method which uses externalities via the Environment trait can be
   * tested.
   *
   * @throws \Exception
   */
  public function printSquareRootOfNumberOfFilesInDirectory() {
    $directory = $this->getEnv('DIRECTORY');
    if (!$directory) {
      throw new \Exception('Please set the DIRECTORY environment variable.');
    }
    $files = $this->scanDir($directory);
    $sqrt = $this->squareRoot(count($files));
    $this->print($sqrt);
  }

  /**
   * Returns the square root of a number.
   *
   * This is added to show an example of how the associated test code
   * (see ./code/test/AppTest.php) works for a pure function with no
   * externalities.
   *
   * @param float $a
   *   The number whose square root we want to get.
   *
   * @return float
   *   The square root.
   *
   * @throws \Exception
   */
  public function squareRoot(float $a) : float {
    if ($a < 0) {
      throw new \Exception('No square root for negative numbers.');
    }
    return sqrt($a);
  }

}
