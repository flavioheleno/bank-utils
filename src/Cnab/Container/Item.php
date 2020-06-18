<?php
declare(strict_types = 1);

namespace BankUtils\Cnab\Container;

use Iterator;
use RuntimeException;
use Serializable;

class Item implements Iterator, Serializable {
  /**
   * @var array<string, \BankUtils\Cnab\Container\Record>
   */
  private $segments;

  /**
   * @param array<string, \BankUtils\Cnab\Container\Record> $segments
   */
  public function __construct(array $segments) {
    $this->segments = $segments;
  }

  public function countSegments(): int {
    return count($this->segments);
  }

  public function getSegment(string $segment): Record {
    if (isset($this->segments[$segment]) === false) {
      throw new RuntimeException(sprintf('Undefined segment "%s"', $segment));
    }

    return $this->segments[$segment];
  }

  /**
   * @return array<string, \BankUtils\Cnab\Container\Record>
   */
  public function getSegments(): array {
    return $this->segments;
  }

  /**
   * @return array<int, mixed>
   */
  public function getRaw(): array {
    $raw = [];
    foreach ($this->segments as $segment) {
      $raw[] = $segment->getRaw();
    }

    return $raw;
  }

  public function __isset(string $segment): bool {
    return isset($this->segments[$segment]);
  }

  public function __get(string $segment): Record {
    return $this->getSegment($segment);
  }

  public function rewind(): void {
    reset($this->segments);
  }

  /**
   * @return mixed
   */
  public function current() {
    return current($this->segments);
  }

  /**
   * @return mixed
   */
  public function key() {
    return key($this->segments);
  }

  public function next(): void {
    next($this->segments);
  }

  public function valid(): bool {
    return current($this->segments) !== false;
  }

  public function serialize(): string {
    return serialize($this->segments);
  }

  /**
   * @param string $data
   *
   * @return void
   */
  public function unserialize($data) {
    $this->segments = unserialize($data);
  }
}
