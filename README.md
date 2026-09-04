<div align="center" style="padding-bottom: 48px">
  <a href="https://assegaiphp.com/" target="blank"><img src="https://assegaiphp.com/images/logos/logo-cropped.png" width="200" alt="AssegaiPHP Logo"></a>
</div>

<p align="center">
  <a href="https://github.com/assegaiphp/validation/releases"><img alt="Latest release" src="https://img.shields.io/github/v/release/assegaiphp/validation?display_name=tag&sort=semver&style=flat-square"></a>
  <a href="https://github.com/assegaiphp/validation/actions/workflows/php.yml"><img alt="Tests" src="https://img.shields.io/github/actions/workflow/status/assegaiphp/validation/php.yml?branch=main&label=tests&style=flat-square"></a>
  <img alt="PHP 8.4+" src="https://img.shields.io/badge/PHP-8.4%2B-777BB4?style=flat-square&logo=php&logoColor=white">
  <a href="https://github.com/assegaiphp/validation/blob/main/LICENSE"><img alt="License" src="https://img.shields.io/github/license/assegaiphp/validation?style=flat-square"></a>
  <img alt="Status active" src="https://img.shields.io/badge/status-active-10b981?style=flat-square">
</p>

# AssegaiPHP Validation

<p align="center">Rule- and attribute-based validation for PHP values and AssegaiPHP DTOs.</p>

`assegaiphp/validation` provides a standalone validator and the property attributes used by Core's DTO validation path. The package intentionally focuses on validation; request binding and response handling remain Core responsibilities.

## Requirements

- PHP 8.4 or newer

## Installation

```bash
composer require assegaiphp/validation
```

## Validate a value

```php
use Assegai\Validation\Validator;

$validator = new Validator();

if (!$validator->validate('developer@example.com', 'required|email')) {
  $errors = $validator->getErrors();
}
```

The validator accepts pipe-separated rule names. Its registered shorthand rules are:

- `alpha`, `alphaNum`, `string`, `numeric`, and `integer`
- `required`, `email`, `domain`, and `url`
- `between`, `min`, `max`, `minLength`, and `maxLength`
- `equalTo`, `notEqualTo`, `inList`, `notInList`, and `regex`

## Add a custom rule

Custom rules implement `IValidationRule` and can be registered by name:

```php
use Assegai\Validation\Interfaces\IValidationRule;
use Assegai\Validation\Validator;

final class EvenNumberRule implements IValidationRule
{
  public function passes(mixed $value): bool
  {
    return is_int($value) && $value % 2 === 0;
  }

  public function getErrorMessage(): string
  {
    return 'The value must be an even integer.';
  }
}

$validator = new Validator();
$validator->addRule('even', EvenNumberRule::class);
$valid = $validator->validate(4, 'even');
```

## DTO attributes

Core can validate public DTO properties using the package's native PHP attributes. The current property-validation surface includes:

- `IsAlpha`, `IsAlphanumeric`, `IsAscii`, and `IsString`
- `IsArray`, `IsInt`, and `IsNumber`
- `IsBetween`, `IsEqualTo`, `IsEmpty`, and `IsNotEmpty`
- `IsDate`, `IsDomain`, `IsEmail`, and `IsUrl`

See the [AssegaiPHP guide](https://assegaiphp.com/guide) for request binding, DTO hydration, validation pipes, and generated OpenAPI schemas.

## Contributing

For contribution and pull request conventions, see [Commit and PR Guidelines](./docs/commit-and-pr-guidelines.md).

## License

This package is released under the [MIT license](./LICENSE).
