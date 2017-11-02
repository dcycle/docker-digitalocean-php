<?php

/**
 * @file
 * Test Environment.
 */

use digitalocean_php\traits\Environment;
use PHPUnit\Framework\TestCase;

/**
 * Dummy object using Environment for testing.
 */
class EnvironmentObject {
  use Environment;

}

/**
 * Test Environment.
 *
 * @group digitalocean_php
 */
class EnvironmentTest extends TestCase {

  /**
   * Test for pregMatch().
   *
   * @param string $message
   *   The test message.
   * @param string $pattern
   *   The input pattern.
   * @param string $subject
   *   The input subject.
   * @param string $exception
   *   The expected expection, if any..
   * @param bool $expected
   *   The expected result, ignored if there is an exception.
   *
   * @cover ::pregMatch
   * @dataProvider providerPregMatch
   */
  public function testPregMatch(string $message, string $pattern, string $subject, string $exception, bool $expected = FALSE) {
    $object = new EnvironmentObject();
    if ($exception) {
      $this->expectException($exception);
    }
    $result = $object->pregMatch($pattern, $subject);
    $this->assertTrue($result == $expected, $message);
  }

  /**
   * Provider for testPregMatch().
   */
  public function providerPregMatch() {
    return [
      [
        'Match exists',
        '/.*/',
        'Whatever',
        '',
        TRUE,
      ],
      [
        'Match does not exist',
        '/*/',
        'Whatever',
        '\Exception',
      ],
    ];
  }

  /**
   * Smoke test for the environment trait.
   *
   * We cannot test the methods because they are wrappers for environment
   * functions. However, just making sure creating an object of the class
   * which uses Environment will confirm that it does not break anything.
   */
  public function testSmokeTest() {
    $this->assertTrue(is_object(new EnvironmentObject()));
  }

}
