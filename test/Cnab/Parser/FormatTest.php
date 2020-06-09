<?php
declare(strict_types = 1);

namespace BankUtilsTest\Cnab\Parser;

use BankUtils\Cnab\Exception\InvalidFormat;
use BankUtils\Cnab\Parser\Format;
use PHPUnit\Framework\TestCase;

class FormatTest extends TestCase {
  public function testEmtpyFormat(): void {
    $this->expectException(InvalidFormat::class, 'Invalid data format: ""');
    $f = new Format('');
  }

  public function testInvalidFormat1(): void {
    $this->expectException(InvalidFormat::class, 'Invalid data format: "A(001)"');
    $f = new Format('A(001)');
  }

  public function testInvalidFormat2(): void {
    $this->expectException(InvalidFormat::class, 'Invalid data format: "9(1)"');
    $f = new Format('9(1)');
  }

  public function testInvalidFormat3(): void {
    $this->expectException(InvalidFormat::class, 'Invalid data format: "X(001)V1"');
    $f = new Format('X(001)V1');
  }

  public function testInvalidFormat4(): void {
    $this->expectException(InvalidFormat::class, 'Invalid data format: "9(001)V01"');
    $f = new Format('9(001)V01');
  }

  public function testAlpha(): void {
    $f = new Format('X(003)');
    $this->assertSame($f->getType(), 'X');
    $this->assertFalse($f->isNumeric());
    $this->assertTrue($f->isAlpha());
    $this->assertSame($f->getSize(), 3);
    $this->assertSame($f->getPrecision(), 0);
  }

  public function testNumericInt(): void {
    $f = new Format('9(001)');
    $this->assertSame($f->getType(), '9');
    $this->assertTrue($f->isNumeric());
    $this->assertFalse($f->isAlpha());
    $this->assertSame($f->getSize(), 1);
    $this->assertSame($f->getPrecision(), 0);
  }

  public function testNumericFloat(): void {
    $f = new Format('9(001)V2');
    $this->assertSame($f->getType(), '9');
    $this->assertTrue($f->isNumeric());
    $this->assertFalse($f->isAlpha());
    $this->assertSame($f->getSize(), 3);
    $this->assertSame($f->getPrecision(), 2);
  }

  public function testCreate(): void {
    $f = Format::create('X(001)');
    $this->assertSame($f, Format::create('X(001)'));
  }
}
