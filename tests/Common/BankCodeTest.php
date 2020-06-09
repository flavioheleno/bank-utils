<?php
declare(strict_types = 1);

namespace BankUtilsTest\Common;

use BankUtils\Common\BankCode;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class BankCodeTest extends TestCase {
  public function testValidCode(): void {
    $this->assertTrue(BankCode::validCode('001'));
    $this->assertFalse(BankCode::validCode('000'));
  }

  public function testValidCodeExceptionSmaller() {
    $this->expectException(InvalidArgumentException::class);
    BankCode::validCode('00');
  }

  public function testValidCodeExceptionLarger() {
    $this->expectException(InvalidArgumentException::class);
    BankCode::validCode('0000');
  }

  public function testValidCodeExceptionInvalid() {
    $this->expectException(InvalidArgumentException::class);
    BankCode::validCode('abc');
  }

  public function testGetName() {
    $this->assertSame('Banco do Brasil S.A.', BankCode::getName('001'));
  }

  public function testGetNameNotFoundException() {
    $this->expectException(RuntimeException::class);
    BankCode::getName('000');
  }

  public function testGetNameExceptionSmaller() {
    $this->expectException(InvalidArgumentException::class);
    BankCode::getName('00');
  }

  public function testGetNameExceptionLarger() {
    $this->expectException(InvalidArgumentException::class);
    BankCode::getName('0000');
  }

  public function testGetNameExceptionInvalid() {
    $this->expectException(InvalidArgumentException::class);
    BankCode::getName('abc');
  }

  public function testGetUrl() {
    $this->assertSame('www.bb.com.br', BankCode::getUrl('001'));
  }

  public function testGetUrlNotFoundException() {
    $this->expectException(RuntimeException::class);
    BankCode::getUrl('000');
  }

  public function testGetUrlExceptionSmaller() {
    $this->expectException(InvalidArgumentException::class);
    BankCode::getUrl('00');
  }

  public function testGetUrlExceptionLarger() {
    $this->expectException(InvalidArgumentException::class);
    BankCode::getUrl('0000');
  }

  public function testGetUrlExceptionInvalid() {
    $this->expectException(InvalidArgumentException::class);
    BankCode::getUrl('abc');
  }
}
