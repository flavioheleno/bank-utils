<?php
declare(strict_types = 1);

namespace BankUtilsTest\Cnab\Container;

use BankUtils\Cnab\Container\Batch;
use BankUtils\Cnab\Container\File;
use BankUtils\Cnab\Container\Item;
use BankUtils\Cnab\Container\Record;
use PHPUnit\Framework\TestCase;
use OutOfBoundsException;
use RuntimeException;

class FileTest extends TestCase {
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
  protected $batchHeader;
  /**
   * @var \BankUtils\Cnab\Container\Record
   */
  protected $batchTrailer;
  /**
   * @var \BankUtils\Cnab\Container\Batch
   */
  protected $batch;
  /**
   * @var \BankUtils\Cnab\Container\Record
   */
  protected $fileHeader;
  /**
   * @var \BankUtils\Cnab\Container\Record
   */
  protected $fileTrailer;
  /**
   * @var \BankUtils\Cnab\Container\File
   */
  protected $file;

  protected function setUp(): void {
    $this->record = new Record(
      ['a' => 'b'],
      'raw'
    );

    $this->item = new Item(
      ['seg' => $this->record]
    );

    $this->batchHeader = new Record(
      ['c' => 'd'],
      'rawBH'
    );

    $this->batchTrailer = new Record(
      ['e' => 'f'],
      'rawBT'
    );

    $this->batch = new Batch(
      $this->batchHeader,
      [$this->item],
      $this->batchTrailer
    );

    $this->fileHeader = new Record(
      ['g' => 'h'],
      'rawFH'
    );

    $this->fileTrailer = new Record(
      ['i' => 'j'],
      'rawFT'
    );

    $this->file = new File(
      $this->fileHeader,
      [$this->batch],
      $this->fileTrailer
    );
  }

  public function testGetHeader(): void {
    $this->assertSame($this->file->getHeader(), $this->fileHeader);
  }

  public function testCountBatches(): void {
    $this->assertSame($this->file->countBatches(), 1);
  }

  public function testGetBatch(): void {
    $this->assertEquals($this->file->getBatch(0), $this->batch);
    $this->expectException(OutOfBoundsException::class);
    $x = $this->file->getBatch(1);
  }

  public function testGetBatches(): void {
    $this->assertEquals($this->file->getBatches(), [$this->batch]);
  }

  public function testGetTrailer(): void {
    $this->assertSame($this->file->getTrailer(), $this->fileTrailer);
  }

  public function testGetRaw(): void {
    $this->assertEquals(
      $this->file->getRaw(),
      [
        'rawFH',
        [
          'rawBH',
          ['raw'],
          'rawBT'
        ],
        'rawFT'
      ]
    );
  }

  public function testDynamicGet(): void {
    $this->assertSame($this->file->header, $this->fileHeader);
    $this->assertEquals($this->file->batches, [$this->batch]);
    $this->assertSame($this->file->trailer, $this->fileTrailer);
    $this->expectException(RuntimeException::class, 'Undefined property "undef"');
    $x = $this->file->undef;
  }

  public function testSerialization(): void {
    $serialized = serialize($this->file);

    $this->assertEquals($this->file, unserialize($serialized));
  }
}
