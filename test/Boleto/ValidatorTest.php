<?php
declare(strict_types = 1);

namespace BankUtilsTest\Boleto;

use BankUtils\Boleto\Validator;
use BankUtils\Boleto\Parser;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase {
  public function testCheckLineValid1(): void {
    $this->assertTrue(Validator::checkLine('00190000090281913600966281313172600000000000000'));
  }

  public function testCheckLineValid2(): void {
    $this->assertTrue(Validator::checkLine('42297115040000195441160020034520268610000054659'));
  }

  public function testCheckLineNotValid(): void {
    $this->assertFalse(Validator::checkLine('42297115040000196441160020034520268610000054659'));
  }

  public function testCheckLineInvalid(): void {
    $this->expectException(InvalidArgumentException::class);
    Validator::checkLine('4229711504000019544116002003452026861000005465');
  }

  public function testCheckBoletoValid1(): void {
    $boleto = Parser::fromLine('00190000090281913600966281313172600000000000000');
    $this->assertTrue(Validator::checkBoleto($boleto));
  }

  public function testCheckBoletoValid2(): void {
    $boleto = Parser::fromLine('42297115040000195441160020034520268610000054659');
    $this->assertTrue(Validator::checkBoleto($boleto));
  }

  public function testCheckBoletoNotValid(): void {
    $boleto = Parser::fromLine('42297115040000196441160020034520268610000054659');
    $this->assertFalse(Validator::checkBoleto($boleto));
  }
}
