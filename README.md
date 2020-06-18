# bank-utils [![Build Status](https://travis-ci.com/flavioheleno/bank-utils.svg?branch=master)](https://travis-ci.com/flavioheleno/bank-utils) [![Maintainability](https://api.codeclimate.com/v1/badges/d778eb1514509d581876/maintainability)](https://codeclimate.com/github/flavioheleno/bank-utils/maintainability)
Simple and straightforward Bank Utilities.

## Install with composer

```shell
composer require flavioheleno/bank-utils
```

## Boleto

### Parsing a typeable line

```php
$line = '00190000090281913600966281313172600000000000000';
$boleto = BankUtils\Boleto\Parser::fromLine($line);

// string(3) "001"
$boleto->getIssuerBank();

// int(9));
$boleto->getCurrency();

// string(5) "00000"
$boleto->getIssuerReserve1();

// int(9)());
$boleto->getCheckDigit1();

// string(10) "0281913600"
$boleto->getIssuerReserve2();

 // int(9)());
$boleto->getCheckDigit2();

// string(10) "6628131317"
$boleto->getIssuerReserve3();

 // int(2)());
$boleto->getCheckDigit3();

// int(6)
$boleto->getGeneralCheckDigit();

// object(DateTimeImmutable)#2380 (3) {
//   ["date"]=>
//   string(26) "1997-10-07 00:00:00.000000"
//   ["timezone_type"]=>
//   int(3)
//   ["timezone"]=>
//   string(17) "America/Sao_Paulo"
// }
$boleto->getDueDate();

// object(Money\Money)#2376 (2) {
//   ["amount":"Money\Money":private]=>
//   string(1) "0"
//   ["currency":"Money\Money":private]=>
//   object(Money\Currency)#2379 (1) {
//     ["code":"Money\Currency":private]=>
//     string(3) "BRL"
//   }
// }
$boleto->getAmount();
```

### Validanting a typeable line

```php
$line = '00190000090281913600966281313172600000000000000';

// bool(true)
BankUtils\Boleto\Validator::checkLine($line);
```

You could also validate a parsed Boleto:

```php
$line = '00190000090281913600966281313172600000000000000';
$boleto = BankUtils\Boleto\Parser::fromLine($line);

// bool(true)
BankUtils\Boleto\Validator::checkBoleto($boleto);
```

## CNAB Files

CNAB parsing depends on a Provider implementation, which is nothing more than a few field naming and size setup.

A sample can be seen [here](src/Cnab/Provider/Febraban/Cnab240.php).

### Parsing a CNAB file

```php
$filePath = '/path/to/file.cnab';
$provider = BankUtils\Cnab\Provider\Febraban\Cnab240::class;

$cnabFile = BankUtils\Cnab\Reader::fromFile($filePath, $provider);

```

Alternatively, you can also parse from a `string` or an `array`:

```php
$filePath = '/path/to/file.cnab';
$provider = BankUtils\Cnab\Provider\Febraban\Cnab240::class;

$str = file_get_contents($filePath);
$cnabFile = BankUtils\Cnab\Reader::fromString($str, $provider);

$arr = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$cnabFile = BankUtils\Cnab\Reader::fromArray($arr, $provider);
```

### Writing a CNAB file

```php
$cnabFile = new BankUtils\Cnab\Container\File(...);
$filePath = '/path/to/file.cnab';
$provider = BankUtils\Cnab\Provider\Febraban\Cnab240::class;

$bool = BankUtils\Cnab\Writer::toFile($filePath, $cnabFile, $provider);
```

Alternatively, you can also write to a `string` or an `array`:

```php
$cnabFile = new BankUtils\Cnab\Container\File(...);
$provider = BankUtils\Cnab\Provider\Febraban\Cnab240::class;

$str = BankUtils\Cnab\Writer::toString($cnabFile, $provider);

$arr = BankUtils\Cnab\Writer::toArray($cnabFile, $provider);
```

## Helpers

### Bank Codes

This helper is ideal for using along with Boleto and CNAB as they only carry bank codes.

#### Checking code validity

```php
// bool(true)
BankUtils\Common\BankCode::validCode('001');


// bool(false)
BankUtils\Common\BankCode::validCode('000');
```

#### Get bank name

```php
// string(20) "Banco do Brasil S.A."
BankUtils\Common\BankCode::getName('001');
```

#### Get bank url

```php
// string(13) "www.bb.com.br"
BankUtils\Common\BankCode::getUrl('001');
```

## Contributing

There are a few helper scripts that can be called by composer, such as:

- Static Code Analysis: `php composer.phar run check`
- Code Linting: `php composer.phar run lint`
- Tests: `php composer.phar run test`

**NOTE:** to run the *Code Linting*, you must download the ruleset from [here](https://github.com/flavioheleno/phpcs-ruleset/blob/master/ruleset.xml) first.

## License

This library is licensed under the [MIT License](LICENSE).
