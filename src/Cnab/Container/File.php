<?php
declare(strict_types = 1);

namespace BankUtils\Cnab\Container;

use OutOfBoundsException;
use RuntimeException;
use Serializable;

class File implements Serializable {
  /**
   * @var \BankUtils\Cnab\Container\Record
   */
  private $header;
  /**
   * @var array<int,\BankUtils\Cnab\Container\Batch>
   */
  private $batches;
  /**
   * @var \BankUtils\Cnab\Container\Record
   */
  private $trailer;

  /**
   * @param \BankUtils\Cnab\Container\Record $header
   * @param array<int,\BankUtils\Cnab\Container\Batch> $batches
   * @param \BankUtils\Cnab\Container\Record $trailer
   */
  public function __construct(Record $header, array $batches, Record $trailer) {
    $this->header  = $header;
    $this->batches = $batches;
    $this->trailer = $trailer;
  }

  public function getHeader(): Record {
    return $this->header;
  }

  public function countBatches(): int {
    return count($this->batches);
  }

  public function getBatch(int $index): Batch {
    if (isset($this->batches[$index]) === false) {
      throw new OutOfBoundsException();
    }

    return $this->batches[$index];
  }

  /**
   * @return array<int,\BankUtils\Cnab\Container\Batch>
   */
  public function getBatches(): array {
    return $this->batches;
  }

  public function getTrailer(): Record {
    return $this->trailer;
  }

  /**
   * @return array<int,string>
   */
  public function getRaw(): array {
    $raw = [];
    $raw[] = $this->header->getRaw();
    foreach ($this->batches as $batch) {
      $raw[] = $batch->getRaw();
    }

    $raw[] = $this->trailer->getRaw();
    return $raw;
  }

  /**
   * @return \BankUtils\Cnab\Container\Record|array<int,\BankUtils\Cnab\Container\Batch>|array<int,string>
   */
  public function __get(string $property) {
    switch ($property) {
      case 'header':
        return $this->header;
      case 'batches':
        return $this->batches;
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
        $this->batches,
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
    [$this->header, $this->batches, $this->trailer] = unserialize($data);
  }
}
