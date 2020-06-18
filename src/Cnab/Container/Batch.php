<?php
declare(strict_types = 1);

namespace BankUtils\Cnab\Container;

use OutOfBoundsException;
use RuntimeException;
use Serializable;

class Batch implements Serializable {
  /**
   * @var \BankUtils\Cnab\Container\Record
   */
  private $header;
  /**
   * @var array<int, \BankUtils\Cnab\Container\Item>
   */
  private $items;
  /**
   * @var \BankUtils\Cnab\Container\Record
   */
  private $trailer;

  /**
   * @param \BankUtils\Cnab\Container\Record $header
   * @param array<int, \BankUtils\Cnab\Container\Item> $items
   * @param \BankUtils\Cnab\Container\Record $trailer
   *
   * @return void
   */
  public function __construct(Record $header, array $items, Record $trailer) {
    $this->header  = $header;
    $this->items   = $items;
    $this->trailer = $trailer;
  }

  public function getHeader(): Record {
    return $this->header;
  }

  public function countItems(): int {
    return count($this->items);
  }

  public function getItem(int $index): Item {
    if (isset($this->items[$index]) === false) {
      throw new OutOfBoundsException();
    }

    return $this->items[$index];
  }

  /**
   * @return array<int, \BankUtils\Cnab\Container\Item>
   */
  public function getItems(): array {
    return $this->items;
  }

  public function getTrailer(): Record {
    return $this->trailer;
  }

  /**
   * @return array<int, array<int, array<int, string>|string>|string>
   */
  public function getRaw(): array {
    $raw = [];
    $raw[] = $this->header->getRaw();
    foreach ($this->items as $item) {
      $raw[] = $item->getRaw();
    }

    $raw[] = $this->trailer->getRaw();

    return $raw;
  }

  /**
   * @return \BankUtils\Cnab\Container\Record|array<int, \BankUtils\Cnab\Container\Item>|array<int, string>
   */
  public function __get(string $property) {
    switch ($property) {
      case 'header':
        return $this->header;
      case 'items':
        return $this->items;
      case 'trailer':
        return $this->trailer;
      default:
        throw new RuntimeException(sprintf('Undefined property "%s"', $property));
    }
  }

  public function serialize(): string {
    return serialize(
      [
        $this->header,
        $this->items,
        $this->trailer
      ]
    );
  }

  /**
   * @param string $data
   *
   * @return void
   */
  public function unserialize($data) {
    [$this->header, $this->items, $this->trailer] = unserialize($data);
  }
}
