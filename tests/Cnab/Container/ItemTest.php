<?php
declare(strict_types = 1);

namespace BankUtilsTest\Cnab\Container;

use BankUtils\Cnab\Container\Item;
use BankUtils\Cnab\Container\Record;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ItemTest extends TestCase {
  /**
   * @var \BankUtils\Cnab\Container\Record
   */
  protected $record;
  /**
   * @var \BankUtils\Cnab\Container\Item
   */
  protected $item;

  protected function setUp(): void {
    $this->record = new Record(
      ['a' => 'b'],
      'raw'
    );

    $this->item = new Item(
      ['seg' => $this->record]
    );
  }

  public function testCountSegments(): void {
    $this->assertSame($this->item->countSegments(), 1);
  }

  public function testGetSegment(): void {
    $this->assertEquals($this->item->getSegment('seg'), $this->record);
    $this->expectException(RuntimeException::class, 'Undefined segment "undef"');
    $x = $this->item->getSegment('undef');
  }

  public function testGetSegments(): void {
    $this->assertEquals($this->item->getSegments(), ['seg' => $this->record]);
  }

  public function testGetRaw(): void {
    $this->assertEquals($this->item->getRaw(), ['raw']);
  }

  public function testIsset(): void {
    $this->assertTrue(isset($this->item->seg));
    $this->assertFalse(isset($this->item->undef));
  }

  public function testDynamicGet(): void {
    $this->assertSame($this->item->seg, $this->record);
    $this->expectException(RuntimeException::class, 'Undefined segment "undef"');
    $x = $this->item->undef;
  }

  public function testIterator(): void {
    $this->item->rewind();
    $this->assertEquals($this->item->current(), $this->record);
    $this->assertSame($this->item->key(), 'seg');
    $this->assertTrue($this->item->valid());
    $this->item->next();
    $this->assertFalse($this->item->current());
    $this->assertNull($this->item->key());
    $this->assertFalse($this->item->valid());
  }

  public function testSerialization(): void {
    $serialized = serialize($this->item);

    $this->assertEquals($this->item, unserialize($serialized));
  }
}
