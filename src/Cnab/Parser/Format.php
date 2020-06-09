<?php
declare(strict_types = 1);

namespace BankUtils\Cnab\Parser;

use BankUtils\Cnab\Exception;

class Format {
  /**
   * @var string
   */
  private $type;
  /**
   * @var int
   */
  private $size;
  /**
   * @var int
   */
  private $prec;

  public static function create(string $format): self {
    static $cache = [];
    if (isset($cache[$format]) === false) {
      $cache[$format] = new self($format);
    }

    return $cache[$format];
  }

  public function __construct(string $format) {
    $matches = [];
    $regex = '/^(X\((?<strsize>[0-9]{3})\)|9\((?<numsize>[0-9]{3})\)(V(?<precision>[0-9]))?)$/i';
    if (preg_match($regex, $format, $matches) !== 1) {
      throw new Exception\InvalidFormat(sprintf('Invalid data format: "%s"', $format));
    }

    $this->type = strtoupper($matches[1][0]);
    if ($this->type === 'X') {
        $this->size = (int)$matches['strsize'];
        $this->prec = 0;

        return;
    }

    $this->size = (int)$matches['numsize'];
    $this->prec = (int)($matches['precision'] ?? 0);
  }

  public function getType(): string {
    return $this->type;
  }

  public function isNumeric(): bool {
    return $this->type === '9';
  }

  public function isAlpha(): bool {
    return $this->type === 'X';
  }

  public function getSize(): int {
    if ($this->isNumeric()) {
      return $this->size + $this->prec;
    }

    return $this->size;
  }

  public function getPrecision(): int {
    return $this->prec;
  }
}
