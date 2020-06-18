<?php
declare(strict_types = 1);

namespace BankUtils\Cnab;

use BadFunctionCallException;
use BankUtils\Cnab\Container\File;
use BankUtils\Cnab\Container\Record;
use BankUtils\Cnab\Parser\Format;
use RuntimeException;

class Writer {
  /**
   * @param \BankUtils\Cnab\Container\Record $record
   * @param array<string, string> $ruleMap
   *
   * @return string
   */
  private static function compose(Record $record, array $ruleMap): string {
    $lineContent = '';
    foreach ($ruleMap as $name => $rawFormat) {
      $format = Format::create($rawFormat);
      if ($format->isNumeric()) {
        $value = $record->$name * (10 ** $format->getPrecision());
        $lineContent .= str_pad((string)$value, $format->getSize(), '0', STR_PAD_LEFT);

        continue;
      }

      $lineContent .= str_pad($record->$name, $format->getSize(), ' ', STR_PAD_RIGHT);
    }

    return $lineContent;
  }

  /**
   * @param string $filePath
   * @param \BankUtils\Cnab\Container\File $cnab
   * @param string $providerClass
   *
   * @return bool
   */
  public static function toFile(string $filePath, File $cnab, string $providerClass): bool {
    $content = self::toString($cnab, $providerClass);
    return file_put_contents($filePath, $content) === strlen($content);
  }

  /**
   * @param \BankUtils\Cnab\Container\File $cnab
   * @param string $providerClass
   *
   * @return string
   */
  public static function toString(File $cnab, string $providerClass): string {
    return implode("\n", self::toArray($cnab, $providerClass));
  }

  /**
   * @param \BankUtils\Cnab\Container\File $cnab
   * @param string $providerClass
   *
   * @return array<int, string>
   */
  public static function toArray(File $cnab, string $providerClass): array {
    $array = [];
    $array[] = self::compose($cnab->header, $providerClass::fileHeader());
    foreach ($cnab->batches as $batch) {
      $array[] = self::compose($batch->header, $providerClass::batchHeader());
      foreach ($batch->items as $item) {
        foreach ($item as $type => $segment) {
          $methodName = sprintf('segment%s', $type);
          if (method_exists($providerClass, $methodName) === false) {
            throw new BadFunctionCallException(
              sprintf(
                'Call undefined function "%s" in "%s" class',
                $methodName,
                $providerClass
              )
            );
          }

          $array[] = self::compose($segment, $providerClass::{$methodName}());
        }
      }

      $array[] = self::compose($batch->trailer, $providerClass::batchTrailer());
    }

    $array[] = self::compose($cnab->trailer, $providerClass::fileTrailer());

    foreach ($array as $lineIndex => $lineContent) {
      $lineSize = strlen($lineContent);
      if ($lineSize !== $providerClass::lineSize()) {
        throw new RuntimeException(
          sprintf(
            'Line %d is %d bytes long, format requires %d bytes.',
            $lineIndex + 1,
            $lineSize,
            $providerClass::lineSize()
          )
        );
      }
    }

    return $array;
  }
}
