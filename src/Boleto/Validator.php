<?php
declare(strict_types = 1);

namespace BankUtils\Boleto;

use InvalidArgumentException;

/**
 * This class validates the typeable line.
 */
final class Validator {
  private static function mod10(string $block): bool {
    $blockSize  = strlen($block) - 1;
    $checkDigit = (int)$block[$blockSize];

    $code = substr($block, 0, $blockSize);
    $code = strrev($code);
    $code = array_map('intval', str_split($code));

    $sum = 0;
    foreach ($code as $index => $value) {
      if ($index % 2 === 0) {
        $value *= 2;
        if ($value > 9) {
          $value = array_sum(str_split((string)$value));
        }
      }

      $sum += $value;
    }

    $probe = 10 - ($sum % 10);
    if ($probe === 10) {
      $probe = 0;
    }

    return $probe === $checkDigit;
  }

  /**
   * @param array<int, string> $blocks
   *
   * @return bool
   */
  private static function validBlocks(array $blocks): bool {
    $validCount = 0;
    foreach ($blocks as $block) {
      if (self::mod10($block) === true) {
        $validCount++;
      }
    }

    return $validCount === count($blocks);
  }

  public static function checkLine(string $line): bool {
    $line = str_replace([' ', '.'], '', $line);
    if (preg_match('/^[0-9]{47}$/', $line) !== 1) {
      throw new InvalidArgumentException('Line must be exactly 47 numbers.');
    }

    $blocks = [
      substr($line, 0, 10),
      substr($line, 10, 11),
      substr($line, 21, 11)
    ];

    return self::validBlocks($blocks);
  }

  public static function checkBoleto(Boleto $boleto): bool {
    $blocks = [
      sprintf(
        '%s%s%s%s',
        $boleto->getIssuerBank(),
        $boleto->getCurrency(),
        $boleto->getIssuerReserved1(),
        $boleto->getCheckDigit1(),
        $boleto->getIssuerReserved2()
      ),
      sprintf(
        '%s%s',
        $boleto->getIssuerReserved2(),
        $boleto->getCheckDigit2()
      ),
      sprintf(
        '%s%s',
        $boleto->getIssuerReserved3(),
        $boleto->getCheckDigit3()
      )
    ];

    return self::validBlocks($blocks);
  }
}
