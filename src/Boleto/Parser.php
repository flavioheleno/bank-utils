<?php
declare(strict_types = 1);

namespace BankUtils\Boleto;

use BankUtils\Boleto\Boleto;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use Money\Currency;
use Money\Money;

/**
 * This class parses the typeable line into a value object.
 *
 * @link http://www.meusutilitarios.com.br/p/blog-page.html
 */
final class Parser {
  public static function fromLine(string $line): Boleto {
    $line = str_replace([' ', '.'], '', $line);
    if (preg_match('/^[0-9]{47}$/', $line) !== 1) {
      throw new InvalidArgumentException('Line must be exactly 47 numbers.');
    }

    // Posição 01-03 = Identificação do banco (exemplo: 001 = Banco do Brasil)
    $issuerBank = substr($line, 0, 3);
    // Posição 04-04 = Código de moeda (exemplo: 9 = Real)
    $currency = (int)substr($line, 3, 1);

    // Posição 05-09 = 5 primeiras posições do campo livre
    $issuerReserved1 = substr($line, 4, 5);
    // Posição 10-10 = Dígito verificador do primeiro campo
    $checkDigit1 = (int)substr($line, 9, 1);

    // Posição 11-20 = 6 a 15 posições do campo livre
    $issuerReserved2 = substr($line, 10, 10);
    // Posição 21-21 = Dígito verificador do segundo campo
    $checkDigit2 = (int)substr($line, 20, 1);

    // Posição 22-31 = 16 a 25 posições do campo livre
    $issuerReserved3 = substr($line, 21, 10);
    // Posição 32-32 = Dígito verificador do terceiro campo
    $checkDigit3 = (int)substr($line, 31, 1);

    // Posição 33-33 = Dígito verificador geral
    $generalCheckDigit = (int)substr($line, 32, 1);

    // Posição 34-37 = Fator de vencimento
    $dueDate = (int)substr($line, 33, 4);
    $dueDate = DateTimeImmutable::createFromMutable(
      DateTime::createFromFormat(
        'Y-m-d H:i:s',
        '1997-10-07 00:00:00',
        new DateTimeZone('America/Sao_Paulo')
      )
    )->add(new DateInterval(sprintf('P%dD', $dueDate)));
    // Posição 38-47 = Valor nominal do título
    $amount = substr($line, 37, 10);
    $amount = new Money(ltrim($amount, '0') ?: 0, new Currency('BRL'));

    return new Boleto(
      $issuerBank,
      $currency,
      $issuerReserved1,
      $checkDigit1,
      $issuerReserved2,
      $checkDigit2,
      $issuerReserved3,
      $checkDigit3,
      $generalCheckDigit,
      $dueDate,
      $amount
    );
  }
}
