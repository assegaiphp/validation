<div align="center" style="padding-bottom: 48px">
    <a href="https://assegaiphp.com/" target="blank"><img src="https://assegaiphp.com/images/logos/logo-cropped.png" width="200" alt="Assegai Logo"></a>
</div>

<p align="center">
  <a href="https://github.com/assegaiphp/validation/releases"><img alt="Latest release" src="https://img.shields.io/github/v/release/assegaiphp/validation?display_name=tag&sort=semver&style=flat-square"></a>
  <a href="https://github.com/assegaiphp/validation/actions/workflows/php.yml"><img alt="Tests" src="https://img.shields.io/github/actions/workflow/status/assegaiphp/validation/php.yml?branch=main&label=tests&style=flat-square"></a>
  <img alt="PHP 8.4+" src="https://img.shields.io/badge/PHP-8.4%2B-777BB4?style=flat-square&logo=php&logoColor=white">
  <a href="https://github.com/assegaiphp/validation/blob/main/LICENSE"><img alt="License" src="https://img.shields.io/github/license/assegaiphp/validation?style=flat-square"></a>
  <img alt="Status active" src="https://img.shields.io/badge/status-active-10b981?style=flat-square">
</p>

<p align="center">A progressive <a href="https://php.net">PHP</a> framework for building efficient and scalable server-side applications.</p>

# AssegaiPHP Validation

Welcome to the AssegaiPHP validation package! This package is designed to provide a simple and easy-to-use solution for validating data in your AssegaiPHP projects.

## Contribution workflow

For commit and pull request conventions in this repo, see:

- [docs/commit-and-pr-guidelines.md](./docs/commit-and-pr-guidelines.md)

## Installation
To install this package, run the following command in your project's root directory:

```bash
composer require assegaiphp/validation
```

## Basic Usage

To use this package, simply import the `Assegai\Validation\Validator` class and create a new instance. You can then use the `validate()` method to check if a value or array of values meet the specified criteria.

```php
use Assegai\Validation\Validator;

$validator = new Validator();
$isValid = $validator->validate($value, 'required|email');
```

The second argument to the `validate()` method is a string containing the validation rules to apply, separated by the `|` character. In the example above, the required and email rules are applied.

### Create a Validation Rule

```php
use Assegai\Validation\Interfaces\IValidationRule;

class MyCustomValidationRule extends IValidationRule
{
  public function passes(mixed $value): bool
  {
    // validate the value
  }

  public function getErrorMessage(): string
  {
    return 'The value is invalid.';
  }
}
```

## Available Rules

This package comes with a number of built-in validation rules, including:

- `alpha`: value must contain only alphabetic characters
- `alnum`: value must contain only alphanumeric characters
- `between:n,m`: value must be between n and m (inclusive)
- `domain`: value must be a valid domain name
- `email`: value must be a valid email address
- `equalTo:n`: value must be equal to n
- `float`: value must be a floating point number
- `inlist:l`: value is in a specific list of allowed values
- `integer`: value must be an integer
- `maxLength:n`: value must be no more than n characters long
- `max:n`: value does not exceed a maximum value, n
- `minLength:n`: value must be at least n characters long
- `min:n`: value is at least a certain value, n
- `notEqualTo:n`: value must not be equal to n
- `notinlist:l`: value is not in a specific list of disallowed values
- `numeric`: value must be a number
- `regex:n`: value must match the given regex pattern n
- `required`: value must be present
- `string`: value must be a string
- `url`: value must be a valid url

You can also create custom validation rules by extending the Assegai\Validation\Rule class and implementing the validate() method.

## Validation Attributes

| Attribute                                              | 	Description                                                                                                                                                                 |
|--------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Common validation attributes                           |                                                                                                                                                                              |
| #[IsDefined(mixed $value)]                             | Checks if value is defined (!== undefined, !== null). This is the only attribute that ignores skipMissingProperties option.                                                  |
| #[IsOptional]                                          | 	Checks if given value is empty (=== null, === undefined) and if so, ignores all the validators on the property.                                                             |
| #[Equals(mixed $comparison)]                           | 	Checks if value equals ("===") comparison.                                                                                                                                  |
| #[NotEquals(mixed $comparison)]                        | 	Checks if value not equal ("!==") comparison.                                                                                                                               |
| #[IsEmpty]                                             | 	Checks if given value is empty (=== '', === null, === undefined).                                                                                                           |
| #[IsNotEmpty]                                          | 	Checks if given value is not empty (!== '', !== null, !== undefined).                                                                                                       |
| #[IsIn(array $values]                                  | 	Checks if value is in an array of allowed values.                                                                                                                           |
| #[IsNotIn(array $values)]                              | 	Checks if value is not in an array of disallowed values.                                                                                                                    |
| Type validation attributes                             |                                                                                                                                                                              |
| #[IsBoolean]                                           | 	Checks if a value is a boolean.                                                                                                                                             |
| #[IsDate]                                              | 	Checks if the value is a date.                                                                                                                                              |
| #[IsString]                                            | 	Checks if the value is a string.                                                                                                                                            |
| #[IsNumber(IsNumberOptions $options)]                  | 	Checks if the value is a number.                                                                                                                                            |
| #[IsInt]                                               | 	Checks if the value is an integer number.                                                                                                                                   |
| #[IsArray]                                             | 	Checks if the value is an array                                                                                                                                             |
| #[IsEnum(string $enum)]                                | 	Checks if the value is a valid enum                                                                                                                                         |
| Number validation attributes                           |                                                                                                                                                                              |
| #[IsDivisibleBy(num: number)]                          | 	Checks if the value is a number that's divisible by another.                                                                                                                |
| #[IsPositive]                                          | 	Checks if the value is a positive number greater than zero.                                                                                                                 |
| #[IsNegative]                                          | 	Checks if the value is a negative number smaller than zero.                                                                                                                 |
| #[Min(min: number)]                                    | 	Checks if the given number is greater than or equal to given number.                                                                                                        |
| #[Max(max: number)]                                    | 	Checks if the given number is less than or equal to given number.                                                                                                           |
| Date validation attributes                             |                                                                                                                                                                              |
| #[MinDate(string $date]                                | 	Checks if the value is a date that's after the specified date.                                                                                                              |
| #[MaxDate(string $date]                                | 	Checks if the value is a date that's before the specified date.                                                                                                             |
| String-type validation attributes                      |                                                                                                                                                                              |
| #[IsBooleanString]                                     | 	Checks if a string is a boolean (e.g. is "true" or "false" or "1", "0").                                                                                                    |
| #[IsDateString]                                        | 	Alias for @IsISO8601().                                                                                                                                                     |
| #[IsNumberString(?IsNumericOptions $options)]          | 	Checks if a string is a number.                                                                                                                                             |
| String validation attributes                           |                                                                                                                                                                              |
| #[Contains(seed: string)]                              | 	Checks if the string contains the seed.                                                                                                                                     |
| #[NotContains(seed: string)]                           | 	Checks if the string not contains the seed.                                                                                                                                 |
| #[IsAlpha]                                             | 	Checks if the string contains only letters (a-zA-Z).                                                                                                                        |
| #[IsAlphanumeric]                                      | 	Checks if the string contains only letters and numbers.                                                                                                                     |
| #[IsDecimal(?IsDecimalOptions $options)]               | 	Checks if the string is a valid decimal value. Default IsDecimalOptions are force_decimal=False, decimal_digits: '1,', locale: 'en-US'                                      |
| #[IsAscii]                                             | 	Checks if the string contains ASCII chars only.                                                                                                                             |
| #[IsBase32]                                            | 	Checks if a string is base32 encoded.                                                                                                                                       |
| #[IsBase58]                                            | 	Checks if a string is base58 encoded.                                                                                                                                       |
| #[IsBase64(?IsBase64Options $options)]                 | 	Checks if a string is base64 encoded.                                                                                                                                       |
| #[IsIBAN]                                              | 	Checks if a string is a IBAN (International Bank Account Number).                                                                                                           |
| #[IsBIC]                                               | 	Checks if a string is a BIC (Bank Identification Code) or SWIFT code.                                                                                                       |
| #[IsByteLength(int $min, ?int $max)]                   | 	Checks if the string's length (in bytes) falls in a range.                                                                                                                  |
| #[IsCreditCard]                                        | 	Checks if the string is a credit card.                                                                                                                                      |
| #[IsCurrency(?IsCurrencyOptions $options)]             | 	Checks if the string is a valid currency amount.                                                                                                                            |
| #[IsISO4217CurrencyCode]                               | 	Checks if the string is an ISO 4217 currency code.                                                                                                                          |
| #[IsEthereumAddress]                                   | 	Checks if the string is an Ethereum address using basic regex. Does not validate address checksums.                                                                         |
| #[IsBtcAddress]                                        | 	Checks if the string is a valid BTC address.                                                                                                                                |
| #[IsDataURI]                                           | 	Checks if the string is a data uri format.                                                                                                                                  |
| #[IsEmail(?IsEmailOptions $options)]                   | 	Checks if the string is an email.                                                                                                                                           |
| #[IsFQDN(?IsFQDNOptions $options)]                     | 	Checks if the string is a fully qualified domain name (e.g. domain.com).                                                                                                    |
| #[IsFullWidth]                                         | 	Checks if the string contains any full-width chars.                                                                                                                         |
| #[IsHalfWidth]                                         | 	Checks if the string contains any half-width chars.                                                                                                                         |
| #[IsVariableWidth]                                     | 	Checks if the string contains a mixture of full and half-width chars.                                                                                                       |
| #[IsHexColor]                                          | 	Checks if the string is a hexadecimal color.                                                                                                                                |
| #[IsHSL]                                               | 	Checks if the string is an HSL color based on CSS Colors Level 4 specification.                                                                                             |
| #[IsRgbColor(?IsRgbOptions $options)]                  | 	Checks if the string is a rgb or rgba color.                                                                                                                                |
| #[IsIdentityCard(?string $locale)]                     | 	Checks if the string is a valid identity card code.                                                                                                                         |
| #[IsPassportNumber(?string $countryCode)]              | 	Checks if the string is a valid passport number relative to a specific country code.                                                                                        |
| #[IsPostalCode(?string $locale)]                       | 	Checks if the string is a postal code.                                                                                                                                      |
| #[IsHexadecimal]                                       | 	Checks if the string is a hexadecimal number.                                                                                                                               |
| #[IsOctal]                                             | 	Checks if the string is a octal number.                                                                                                                                     |
| #[IsMACAddress(?IsMACAddressOptions $options)]         | 	Checks if the string is a MAC Address.                                                                                                                                      |
| #[IsIP(?IPVersion $version)]                           | 	Checks if the string is an IP (version 4 or 6).                                                                                                                             |
| #[IsPort()]                                            | 	Checks if the string is a valid port number.                                                                                                                                |
| #[IsISBN(?ISBNVersion $version)]                       | 	Checks if the string is an ISBN (version 10 or 13).                                                                                                                         |
| #[IsEAN]                                               | 	Checks if the string is an if the string is an EAN (European Article Number).                                                                                               |
| #[IsISIN]                                              | 	Checks if the string is an ISIN (stock/security identifier).                                                                                                                |
| #[IsISO8601(?IsISO8601Options $options)]               | 	Checks if the string is a valid ISO 8601 date format. Use the option strict = true for additional checks for a valid date.                                                  |
| #[IsJSON]                                              | 	Checks if the string is valid JSON.                                                                                                                                         |
| #[IsJWT]                                               | 	Checks if the string is valid JWT.                                                                                                                                          |
| #[IsObject]                                            | 	Checks if the object is valid Object (null, functions, arrays will return false).                                                                                           |
| #[IsNotEmptyObject]                                    | 	Checks if the object is not empty.                                                                                                                                          |
| #[IsLowercase]                                         | 	Checks if the string is lowercase.                                                                                                                                          |
| #[IsLatLong]                                           | 	Checks if the string is a valid latitude-longitude coordinate in the format lat, long.                                                                                      |
| #[IsLatitude]                                          | 	Checks if the string or number is a valid latitude coordinate.                                                                                                              |
| #[IsLongitude]                                         | 	Checks if the string or number is a valid longitude coordinate.                                                                                                             |
| #[IsMobilePhone(string $locale)]                       | 	Checks if the string is a mobile phone number.                                                                                                                              |
| #[IsISO31661Alpha2]                                    | 	Checks if the string is a valid ISO 3166-1 alpha-2 officially assigned country code.                                                                                        |
| #[IsISO31661Alpha3]                                    | 	Checks if the string is a valid ISO 3166-1 alpha-3 officially assigned country code.                                                                                        |
| #[IsLocale]                                            | 	Checks if the string is a locale.                                                                                                                                           |
| #[IsPhoneNumber(string $region)]                       | 	Checks if the string is a valid phone number using `giggsey/libphonenumber-for-php`.                                                                                        |
| #[IsMongoId]                                           | 	Checks if the string is a valid hex-encoded representation of a MongoDB ObjectId.                                                                                           |
| #[IsMultibyte]                                         | 	Checks if the string contains one or more multibyte chars.                                                                                                                  |
| #[IsNumberString(?IsNumericOptions $options)]          | 	Checks if the string is numeric.                                                                                                                                            |
| #[IsSurrogatePair]                                     | 	Checks if the string contains any surrogate pairs chars.                                                                                                                    |
| #[IsTaxId]                                             | 	Checks if the string is a valid tax ID. Default locale is en-US.                                                                                                            |
| #[IsUrl(?IsURLOptions $options)]                       | 	Checks if the string is a URL.                                                                                                                                              |
| #[IsMagnetURI]                                         | 	Checks if the string is a magnet uri format.                                                                                                                                |
| #[IsUUID(?UUIDVersion $version)]                       | 	Checks if the string is a UUID (version 3, 4, 5 or all ).                                                                                                                   |
| #[IsFirebasePushId]                                    | 	Checks if the string is a Firebase Push ID                                                                                                                                  |
| #[IsUppercase]                                         | 	Checks if the string is uppercase.                                                                                                                                          |
| #[Length(int $min, ?int $max)]                         | 	Checks if the string's length falls in a range.                                                                                                                             |
| #[MinLength(int $min)]                                 | 	Checks if the string's length is not less than given number.                                                                                                                |
| #[MaxLength(int $max)]                                 | 	Checks if the string's length is not more than given number.                                                                                                                |
| #[Matches(RegExp $pattern, ?string $modifiers)]        | 	Checks if string matches the pattern. Either matches('foo', /foo/i) or matches('foo', 'foo', 'i').                                                                          |
| #[IsMilitaryTime]                                      | 	Checks if the string is a valid representation of military time in the format HH:MM.                                                                                        |
| #[IsTimeZone]                                          | 	Checks if the string represents a valid IANA time-zone.                                                                                                                     |
| #[IsHash(string $algorithm)]                           | 	Checks if the string is a hash The following types are supported:md4, md5, sha1, sha256, sha384, sha512, ripemd128, ripemd160, tiger128, tiger160, tiger192, crc32, crc32b. |
| #[IsMimeType]                                          | 	Checks if the string matches to a valid MIME type format                                                                                                                    |
| #[IsSemVer]                                            | 	Checks if the string is a Semantic Versioning Specification (SemVer).                                                                                                       |
| #[IsISSN(?IsISSNOptions $options)]                     | 	Checks if the string is a ISSN.                                                                                                                                             |
| #[IsISRC]                                              | 	Checks if the string is a ISRC.                                                                                                                                             |
| #[IsRFC3339]                                           | 	Checks if the string is a valid RFC 3339 date.                                                                                                                              |
| #[IsStrongPassword(?IsStrongPasswordOptions $options)] | 	Checks if the string is a strong password.                                                                                                                                  |
| Array validation attributes                            |                                                                                                                                                                              |
| #[ArrayContains(array $values)]                        | 	Checks if array contains all values from the given array of values.                                                                                                         |
| #[ArrayNotContains(array $values)]                     | 	Checks if array does not contain any of the given values.                                                                                                                   |
| #[ArrayNotEmpty]                                       | 	Checks if given array is not empty.                                                                                                                                         |
| #[ArrayMinSize(int $min)]                              | 	Checks if the array's length is greater than or equal to the specified number.                                                                                              |
| #[ArrayMaxSize(int $max)]                              | 	Checks if the array's length is less or equal to the specified number.                                                                                                      |
| #[ArrayUnique(?callable $identifier)]                  | 	Checks if all array's values are unique. Comparison for objects is reference-based. Optional function can be speciefied which return value will be used for the comparsion. |
| Object validation attributes                           |                                                                                                                                                                              |
| #[IsInstance(mixed $value)]                            | 	Checks if the property is an instance of the passed value.                                                                                                                  |
| Other attributes                                       |                                                                                                                                                                              |
| #[Allow]                                               | 	Prevent stripping off the property when no other constraint is specified for it.                                                                                            |

## Error Handling

If the validate() method returns false, you can use the getErrors() method to retrieve an array of error messages.

```php
if (!$isValid)
{
  $errors = $validator->getErrors();
  // handle errors
}
```

## Further Reading

For more information on how to use this package, please see the full [documentation](https://assegaiphp.com/gudie/techniques/validation). Thank you for using the AssegaiPHP.
