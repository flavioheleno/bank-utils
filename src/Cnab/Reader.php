<?php
declare(strict_types = 1);

namespace BankUtils\Cnab;

use BadFunctionCallException;
use BankUtils\Cnab\Container\Batch;
use BankUtils\Cnab\Container\File;
use BankUtils\Cnab\Container\Item;
use BankUtils\Cnab\Container\Record;
use BankUtils\Cnab\Exception;
use BankUtils\Cnab\Parser\Format;
use RuntimeException;

class Reader {
  private const FILE_HEADER   = 'fileHeader';
  private const FILE_TRAILER  = 'fileTrailer';
  private const BATCH_HEADER  = 'batchHeader';
  private const BATCH_TRAILER = 'batchTrailer';

  /**
   * @param string $lineContent
   * @param array<string,string> $ruleMap
   * @param bool $keepRaw
   *
   * @return \BankUtils\Cnab\Container\Record
   */
  private static function parse(string $lineContent, array $ruleMap, $keepRaw = true): Record {
    $linePos = 0;
    $values = [];
    foreach ($ruleMap as $name => $rawFormat) {
      $format = Format::create($rawFormat);
      $value = substr($lineContent, $linePos, $format->getSize());
      if ($value === false) {
        throw new RuntimeException(
          sprintf(
            'Failed to parse "%s" from position %d to %d (format: %s).',
            $name,
            $linePos,
            $linePos + $format->getSize(),
            $rawFormat
          )
        );
      }

      $value = trim($value);
      if ($format->isNumeric()) {
        $value = (int)$value;
        if ($format->getPrecision() > 0) {
          $value = $value / (10.0 ** $format->getPrecision());
        }
      }

      $values[$name] = $value;

      $linePos += $format->getSize();
    }

    return new Record($values, $keepRaw === true ? $lineContent : '');
  }

  /**
    * @param string $filePath
    * @param string $providerClass
    *
    * @return \BankUtils\Cnab\Container\File
   */
  public static function fromFile(string $filePath, string $providerClass): File {
    if (is_file($filePath) === false) {
      throw new RuntimeException(sprintf('"%s" is not a file.', $filePath));
    }

    $fileContent = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($fileContent === false) {
      throw new RuntimeException('Failed to read file content.');
    }

    return self::fromArray($fileContent, $providerClass);
  }

  /**
    * @param string $fileContent
    * @param string $providerClass
    *
    * @return \BankUtils\Cnab\Container\File
   */
  public static function fromString(string $fileContent, string $providerClass): File {
    return self::fromArray(explode("\n", $fileContent), $providerClass);
  }

  /**
   * @param array<int,string> $fileContent
   * @param string $providerClass
   *
   * @return \BankUtils\Cnab\Container\File
   */
  public static function fromArray(array $fileContent, string $providerClass): File {
    $ruleMap = $providerClass::map();

    $cnab = [
      'header'  => null,
      'batches' => [],
      'trailer' => null
    ];
    foreach ($fileContent as $lineIndex => $lineContent) {
      $lineContent = rtrim($lineContent, "\r");
      if ($lineContent === '') {
        continue;
      }

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

      $recordType = substr($lineContent, 7, 1);
      if (isset($ruleMap[$recordType]) === false) {
        throw new Exception\InvalidRecord(
          sprintf(
            'Invalid record type "%s" at line %d.',
            $recordType,
            $lineIndex + 1
          )
        );
      }

      switch ($ruleMap[$recordType]) {
        case self::FILE_HEADER:
          if (empty($cnab['header']) === false) {
            throw new Exception\InvalidFile('Multiple file headers found, one expected.');
          }

          $cnab['header'] = self::parse(
            $lineContent,
            $providerClass::fileHeader()
          );

          break;
        case self::FILE_TRAILER:
          if (empty($cnab['header']) === true) {
            throw new Exception\InvalidFile('File trailer found without any file header.');
          }

          if (empty($cnab['trailer']) === false) {
            throw new Exception\InvalidFile('Multiple file trailers found, one expected.');
          }

          if (empty($batch) === false) {
            throw new Exception\InvalidFile('File trailer found with an open batch left.');
          }

          $cnab['trailer'] = self::parse(
            $lineContent,
            $providerClass::fileTrailer()
          );

          break;
        case self::BATCH_HEADER:
          if (empty($batch['header']) === false) {
            throw new Exception\InvalidBatch('Batch header found with an open batch left.');
          }

          $batch = [
            'header'  => self::parse(
              $lineContent,
              $providerClass::batchHeader()
            ),
            'items'   => [],
            'trailer' => null
          ];

          $item = [];

          break;
        case self::BATCH_TRAILER:
          if (empty($batch['header']) === true) {
            throw new Exception\InvalidBatch('Batch trailer found without any batch header.');
          }

          // Ensure batch items are stored
          if (empty($item) === false) {
            $batch['items'][] = new Item($item);
            $item = [];
          }

          $batch['trailer'] = self::parse(
            $lineContent,
            $providerClass::batchTrailer()
          );

          $cnab['batches'][] = new Batch(
            $batch['header'],
            $batch['items'],
            $batch['trailer']
          );
          unset($batch);

          break;
        default:
          // Segment Parsing
          $segmentType = substr($lineContent, 13, 1);
          if (isset($ruleMap[$recordType][$segmentType]) === false) {
            throw new Exception\InvalidSegment(
              sprintf(
                'Invalid segment type "%s" at line %d.',
                $segmentType,
                $lineIndex + 1
              )
            );
          }

          if (isset($batch) === false) {
            throw new Exception\InvalidBatch('Segment found outside batch block.');
          }

          if (isset($item[$segmentType]) === true) {
            $batch['items'][] = new Item($item);
            $item = [];
          }

          if (method_exists($providerClass, $ruleMap[$recordType][$segmentType]) === false) {
            throw new BadFunctionCallException(
              sprintf(
                'Call undefined function "%s" in "%s" class',
                $ruleMap[$recordType][$segmentType],
                $providerClass
              )
            );
          }

          $item[$segmentType] = self::parse(
            $lineContent,
            $providerClass::{$ruleMap[$recordType][$segmentType]}()
          );
      }
    }

    if (empty($cnab['header']) === true) {
      throw new Exception\InvalidFile('File header not found.');
    }

    if (empty($cnab['trailer']) === true) {
      throw new Exception\InvalidFile('File trailer not found.');
    }

    return new File(
      $cnab['header'],
      $cnab['batches'],
      $cnab['trailer']
    );
  }
}
