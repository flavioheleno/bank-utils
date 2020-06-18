<?php
declare(strict_types = 1);

namespace BankUtilsTest\Cnab\Container;

use BankUtils\Cnab\Container\Batch;
use BankUtils\Cnab\Container\Item;
use BankUtils\Cnab\Container\Record;
use PHPUnit\Framework\TestCase;
use OutOfBoundsException;
use RuntimeException;

class BatchTest extends TestCase {
  /**
   * @var \BankUtils\Cnab\Container\Record
   */
  protected $record;
  /**
   * @var \BankUtils\Cnab\Container\Item
   */
  protected $item;
  /**
   * @var \BankUtils\Cnab\Container\Record
   */
  protected $header;
  /**
   * @var \BankUtils\Cnab\Container\Record
   */
  protected $trailer;
  /**
   * @var \BankUtils\Cnab\Container\Batch
   */
  protected $batch;

  protected function setUp(): void {
    $this->record = new Record(
      ['a' => 'b'],
      'raw'
    );

    $this->item = new Item(
      ['seg' => $this->record]
    );

    $this->header = new Record(
      ['c' => 'd'],
      'rawH'
    );

    $this->trailer = new Record(
      ['e' => 'f'],
      'rawT'
    );

    $this->batch = new Batch(
      $this->header,
      [$this->item],
      $this->trailer
    );
  }

  public function testGetHeader(): void {
    $this->assertSame($this->batch->getHeader(), $this->header);
  }

  public function testCountItems(): void {
    $this->assertSame($this->batch->countItems(), 1);
  }

  public function testGetItem(): void {
    $this->assertEquals($this->batch->getItem(0), $this->item);
    $this->expectException(OutOfBoundsException::class);
    $x = $this->batch->getItem(1);
  }

  public function testGetItems(): void {
    $this->assertEquals($this->batch->getitems(), [$this->item]);
  }

  public function testGetTrailer(): void {
    $this->assertSame($this->batch->getTrailer(), $this->trailer);
  }

  public function testGetRaw(): void {
    $this->assertEquals(
      $this->batch->getRaw(),
      [
        'rawH',
        ['raw'],
        'rawT'
      ]
    );
  }

  public function testDynamicGet(): void {
    $this->assertSame($this->batch->header, $this->header);
    $this->assertEquals($this->batch->items, [$this->item]);
    $this->assertSame($this->batch->trailer, $this->trailer);
    $this->expectException(RuntimeException::class);
    $this->expectExceptionMessage('Undefined property "undef"');
    $x = $this->batch->undef;
  }

  public function testSerialization(): void {
    $serialized = serialize($this->batch);

    $this->assertEquals($this->batch, unserialize($serialized));
  }
}
