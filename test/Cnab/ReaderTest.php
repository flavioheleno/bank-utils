<?php
declare(strict_types = 1);

namespace BankUtilsTest\Cnab;

use BankUtils\Cnab\Exception\InvalidFile;
use BankUtils\Cnab\Exception\InvalidRecord;
use BankUtils\Cnab\Provider\Febraban\Cnab240;
use BankUtils\Cnab\Reader;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ReaderTest extends TestCase {
  public function testInvalidFilePath(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testFailToReadFile(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testFromFile(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testFromString(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testLineSize(): void {
    $content = [
      '',
      ' '
    ];
    $this->expectException(RuntimeException::class, 'Line 1 is 1 bytes long, format requires 240 bytes.');
    Reader::fromArray($content, Cnab240::class);
  }

  public function testInvalidRegisterType(): void {
    $content = [
      str_pad('ABCDEFGHIJKLMNOPQRSTUVXYZ', Cnab240::lineSize())
    ];
    $this->expectException(InvalidRecord::class, 'Invalid register type "H" at line 1.');
    Reader::fromArray($content, Cnab240::class);
  }

  public function testMultipleFileHeaders(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testFileTrailerWithoutFileHeader(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testMultipleFileTrailers(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testFileTrailerWithOpenBatch(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testBatchHeaderWithOpenBatch(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testBatchTrailerWithoutBatchHeader(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testInvalidSegmentType(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testSegmentOutsideBatch(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testUndefinedProviderFunction(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testFileHeaderNotFound(): void {
    $this->expectException(InvalidFile::class, 'File header not found.');
    Reader::fromArray([], Cnab240::class);
  }

  public function testFileTrailerNotFound(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testFromArray(): void {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }
}
