<?php
declare(strict_types = 1);

namespace BankUtilsTest\Boleto;

use BankUtils\Boleto\Parser;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase {
  public function testFromLine1(): void {
    $boleto = Parser::fromLine('00190000090281913600966281313172600000000000000');
    $this->assertSame('001', $boleto->getIssuerBank());
    $this->assertSame(9, $boleto->getCurrency());
    $this->assertSame('00000', $boleto->getIssuerReserved1());
    $this->assertSame(9, $boleto->getCheckDigit1());
    $this->assertSame('0281913600', $boleto->getIssuerReserved2());
    $this->assertSame(9, $boleto->getCheckDigit2());
    $this->assertSame('6628131317', $boleto->getIssuerReserved3());
    $this->assertSame(2, $boleto->getCheckDigit3());
    $this->assertSame(6, $boleto->getGeneralCheckDigit());
    $this->assertSame('1997-10-07', $boleto->getDueDate()->format('Y-m-d'));
    $this->assertSame('0', $boleto->getAmount()->getAmount());
  }

  public function testFromLine2(): void {
    $boleto = Parser::fromLine('42297115040000195441160020034520268610000054659');
    $this->assertSame('422', $boleto->getIssuerBank());
    $this->assertSame(9, $boleto->getCurrency());
    $this->assertSame('71150', $boleto->getIssuerReserved1());
    $this->assertSame(4, $boleto->getCheckDigit1());
    $this->assertSame('0000195441', $boleto->getIssuerReserved2());
    $this->assertSame(1, $boleto->getCheckDigit2());
    $this->assertSame('6002003452', $boleto->getIssuerReserved3());
    $this->assertSame(0, $boleto->getCheckDigit3());
    $this->assertSame(2, $boleto->getGeneralCheckDigit());
    $this->assertSame('2016-07-20', $boleto->getDueDate()->format('Y-m-d'));
    $this->assertSame('54659', $boleto->getAmount()->getAmount());
  }

  public function testFromLineInvalid(): void {
    $this->expectException(InvalidArgumentException::class);
    Parser::fromLine('4229711504000019544116002003452026861000005465');
  }
}
