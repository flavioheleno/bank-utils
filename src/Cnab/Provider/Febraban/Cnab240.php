<?php
declare(strict_types = 1);

namespace BankUtils\Cnab\Provider\Febraban;

use BankUtils\Cnab\Contract\Provider;

class Cnab240 implements Provider {
  public static function bankCode(): int {
    return 0;
  }

  public static function lineSize(): int {
    return 240;
  }

  public static function map(): array {
    return [
      '0' => 'fileHeader',
      '1' => 'batchHeader',
      '3' => [
        'A' => 'segmentA',
        'B' => 'segmentB',
        'Z' => 'segmentZ'
      ],
      '5' => 'batchTrailer',
      '9' => 'fileTrailer'
    ];
  }

  public static function fileHeader(): array {
    return [
      'bank'     => '9(003)',
      'batch'    => '9(004)',
      'type'     => '9(001)',
      'reserved' => 'X(009)'
    ];
  }

  public static function fileTrailer(): array {
  }

  public static function batchHeader(): array {
  }

  public static function batchTrailer(): array {
  }
}
