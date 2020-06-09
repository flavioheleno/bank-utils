<?php
declare(strict_types = 1);

namespace BankUtils\Cnab\Contract;

interface Provider {
  public static function bankCode(): int;
  public static function lineSize(): int;

  /**
   * @return array<int,array<string,string>|string>
   */
  public static function map(): array;

  /**
   * @return array<string,string>
   */
  public static function fileHeader(): array;

  /**
   * @return array<string,string>
   */
  public static function fileTrailer(): array;

  /**
   * @return array<string,string>
   */
  public static function batchHeader(): array;

  /**
   * @return array<string,string>
   */
  public static function batchTrailer(): array;
}
