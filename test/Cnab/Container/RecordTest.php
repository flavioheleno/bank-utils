<?php
declare(strict_types = 1);

namespace BankUtilsTest\Cnab\Container;

use BankUtils\Cnab\Container\Record;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class RecordTest extends TestCase {
  /**
   * @var \BankUtils\Cnab\Container\Record
   */
  protected $record;

  protected function setUp(): void {
    $this->record = new Record(
      ['a' => 'b'],
      'raw'
    );
  }

  public function testIsset(): void {
    $this->assertTrue(isset($this->record->a));
    $this->assertFalse(isset($this->record->b));
  }

  public function testDynamicGet(): void {
    $this->assertSame($this->record->a, 'b');
    $this->expectException(RuntimeException::class);
    $this->expectExceptionMessage('Undefined property "b"');
    $x = $this->record->b;
  }

  public function testGetRaw(): void {
    $this->assertSame($this->record->getRaw(), 'raw');
  }

  public function testSerialization(): void {
    $serialized = serialize($this->record);

    $this->assertEquals($this->record, unserialize($serialized));
  }
}
