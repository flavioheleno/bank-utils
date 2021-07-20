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

  public function testValidCodeExceptionSmaller(): void {
    $this->expectException(InvalidArgumentException::class);
    BankCode::validCode('00');
  }

  public function testValidCodeExceptionLarger(): void {
    $this->expectException(InvalidArgumentException::class);
    BankCode::validCode('0000');
  }

  public function testValidCodeExceptionInvalid(): void {
    $this->expectException(InvalidArgumentException::class);
    BankCode::validCode('abc');
  }

  public function testGetName(): void {
    $this->assertSame('Banco do Brasil S.A.', BankCode::getName('001'));
  }

  public function testGetNameNotFoundException(): void {
    $this->expectException(RuntimeException::class);
    BankCode::getName('000');
  }

  public function testGetNameExceptionSmaller(): void {
    $this->expectException(InvalidArgumentException::class);
    BankCode::getName('00');
  }

  public function testGetNameExceptionLarger(): void {
    $this->expectException(InvalidArgumentException::class);
    BankCode::getName('0000');
  }

  public function testGetNameExceptionInvalid(): void {
    $this->expectException(InvalidArgumentException::class);
    BankCode::getName('abc');
  }

  public function testGetUrl(): void {
    $this->assertSame('www.bb.com.br', BankCode::getUrl('001'));
  }

  public function testGetUrlNotFoundException(): void {
    $this->expectException(RuntimeException::class);
    BankCode::getUrl('000');
  }

  public function testGetUrlExceptionSmaller(): void {
    $this->expectException(InvalidArgumentException::class);
    BankCode::getUrl('00');
  }

  public function testGetUrlExceptionLarger(): void {
    $this->expectException(InvalidArgumentException::class);
    BankCode::getUrl('0000');
  }

  public function testGetUrlExceptionInvalid(): void {
    $this->expectException(InvalidArgumentException::class);
    BankCode::getUrl('abc');
  }
}
