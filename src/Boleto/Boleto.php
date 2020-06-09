<?php
declare(strict_types = 1);

namespace BankUtils\Boleto;

use DateTimeImmutable;
use Money\Money;

final class Boleto {
  /**
   * @var string
   */
  private $issuerBank;
  /**
   * @var int
   */
  private $currency;
  /**
   * @var string
   */
  private $issuerReserved1;
  /**
   * @var int
   */
  private $checkDigit1;
  /**
   * @var string
   */
  private $issuerReserved2;
  /**
   * @var int
   */
  private $checkDigit2;
  /**
   * @var string
   */
  private $issuerReserved3;
  /**
   * @var int
   */
  private $checkDigit3;
  /**
   * @var int
   */
  private $generalCheckDigit;
  /**
   * @var \DateTimeImmutable
   */
  private $dueDate;
  /**
   * @var \Money\Money
   */
  private $amount;

  public function __construct(
    string $issuerBank,
    int $currency,
    string $issuerReserved1,
    int $checkDigit1,
    string $issuerReserved2,
    int $checkDigit2,
    string $issuerReserved3,
    int $checkDigit3,
    int $generalCheckDigit,
    DateTimeImmutable $dueDate,
    Money $amount
  ) {
    $this->issuerBank        = $issuerBank;
    $this->currency          = $currency;
    $this->issuerReserved1   = $issuerReserved1;
    $this->checkDigit1       = $checkDigit1;
    $this->issuerReserved2   = $issuerReserved2;
    $this->checkDigit2       = $checkDigit2;
    $this->issuerReserved3   = $issuerReserved3;
    $this->checkDigit3       = $checkDigit3;
    $this->generalCheckDigit = $generalCheckDigit;
    $this->dueDate           = $dueDate;
    $this->amount            = $amount;
  }

  public function getIssuerBank(): string {
    return $this->issuerBank;
  }

  public function getCurrency(): int {
    return $this->currency;
  }

  public function getIssuerReserved1(): string {
    return $this->issuerReserved1;
  }

  public function getCheckDigit1(): int {
    return $this->checkDigit1;
  }

  public function getIssuerReserved2(): string {
    return $this->issuerReserved2;
  }

  public function getCheckDigit2(): int {
    return $this->checkDigit2;
  }

  public function getIssuerReserved3(): string {
    return $this->issuerReserved3;
  }

  public function getCheckDigit3(): int {
    return $this->checkDigit3;
  }

  public function getGeneralCheckDigit(): int {
    return $this->generalCheckDigit;
  }

  public function getDueDate(): DateTimeImmutable {
    return $this->dueDate;
  }

  public function getAmount(): Money {
    return $this->amount;
  }
}
