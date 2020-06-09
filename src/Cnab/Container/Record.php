<?php
declare(strict_types = 1);

namespace BankUtils\Cnab\Container;

use RuntimeException;
use Serializable;

class Record implements Serializable {
  /**
   * @var array<string,mixed>
   */
  protected $properties;
  /**
   * @var string
   */
  protected $rawContent;

  /**
   * @param array<string,mixed> $properties
   * @param string $rawContent
   */
  public function __construct(array $properties, string $rawContent) {
    $this->properties = $properties;
    $this->rawContent = $rawContent;
  }

  public function __isset(string $name): bool {
    return isset($this->properties[$name]);
  }

  /**
   * @return mixed
   */
  public function __get(string $name) {
    if (isset($this->properties[$name]) === false) {
      throw new RuntimeException(sprintf('Undefined property "%s"', $name));
    }

    return $this->properties[$name];
  }

  public function getRaw(): string {
    return $this->rawContent;
  }

  public function serialize(): string {
    return serialize([$this->properties, $this->rawContent]);
  }

  /**
   * @param string $data
   *
   * @return void
   */
  public function unserialize($data) {
    [$this->properties, $this->rawContent] = unserialize($data);
  }
}
