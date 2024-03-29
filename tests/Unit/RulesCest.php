<?php


namespace Tests\Unit;

use Assegai\Validation\Mock\MockEnum;
use Assegai\Validation\Mock\MockStringable;
use Assegai\Validation\Mock\MockText;
use Assegai\Validation\Rules\AlphaNumericValidationRule;
use Assegai\Validation\Rules\AlphaValidationRule;
use Assegai\Validation\Rules\ArrayValidationRule;
use Assegai\Validation\Rules\AsciiValidationRule;
use Assegai\Validation\Rules\BetweenValidationRule;
use Assegai\Validation\Rules\DateValidationRule;
use Assegai\Validation\Rules\DomainNameValidationRule;
use Assegai\Validation\Rules\EmailValidationRule;
use Assegai\Validation\Rules\EmptyValidationRule;
use Assegai\Validation\Rules\EnumValidationRule;
use Assegai\Validation\Rules\EqualToValidationRule;
use Assegai\Validation\Rules\InListValidationRule;
use Assegai\Validation\Rules\IntegerValidationRule;
use Assegai\Validation\Rules\JsonValidationRule;
use Assegai\Validation\Rules\MaxLengthValidationRule;
use Assegai\Validation\Rules\MaxValidationRule;
use Assegai\Validation\Rules\MinLengthValidationRule;
use Assegai\Validation\Rules\MinValidationRule;
use Assegai\Validation\Rules\NotEmptyValidationRule;
use Assegai\Validation\Rules\NotEqualToValidationRule;
use Assegai\Validation\Rules\NotInListValidationRule;
use Assegai\Validation\Rules\NumberValidationRule;
use Assegai\Validation\Rules\NumericValidationRule;
use Assegai\Validation\Rules\PhoneNumberValidationRule;
use Assegai\Validation\Rules\RegexValidationRule;
use Assegai\Validation\Rules\RequiredValidationRule;
use Assegai\Validation\Rules\StringValidationRule;
use Assegai\Validation\Rules\URLValidationRule;
use Tests\Support\UnitTester;

class RulesCest
{
  public function _before(UnitTester $I)
  {
  }

  public function checkTheAlphaValidationRule(UnitTester $I): void
  {
    $rule = new AlphaValidationRule();

    $I->assertTrue($rule->passes("afasdfasdfawfeawfas"));
    $I->assertFalse($rule->passes('fawef323223f2'));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  // tests
  public function checkTheAlphaNumericValidationRule(UnitTester $I): void
  {
    $rule = new AlphaNumericValidationRule();

    $I->assertTrue($rule->passes('aaafdsf1212fsafasd'));
    $I->assertFalse($rule->passes('wef8h23g89##fasdfas'));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheArrayValidationRule(UnitTester $I): void
  {
    $rule = new ArrayValidationRule();

    $I->assertTrue($rule->passes([1, 2, 3, 4, 5]));
    $I->assertTrue($rule->passes(['a', 'b', 'c']));
    $I->assertTrue($rule->passes([]));
    $I->assertTrue($rule->passes([1, 'b', [3, 4]]));
    $I->assertFalse($rule->passes('not an array'));
    $I->assertFalse($rule->passes(123));
    $I->assertFalse($rule->passes((object)['key1' => 'value1', 'key2' => 'value2']));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheAsciiValidationRule(UnitTester $I): void
  {
    $rule = new AsciiValidationRule();

    $I->assertTrue($rule->passes('Hello World!'));
    $I->assertTrue($rule->passes('Welcome to the world of ASCII validation.'));
    $I->assertTrue($rule->passes('1234567890'));
    $I->assertTrue($rule->passes('!@#$%^&*()'));
    $I->assertTrue($rule->passes('abcdefghijklmnopqrstuvwxyz'));
    $I->assertTrue($rule->passes('ABCDEFGHIJKLMNOPQRSTUVWXYZ'));
    $I->assertFalse($rule->passes('áéíóúñäëïöüÿ'));
    $I->assertTrue($rule->passes('The quick brown fox jumps over the lazy dog.'));
    $I->assertFalse($rule->passes('This is a string with a mix of ASCII and non-ASCII characters: ¡™£¢∞§¶•ªº–≠.'));
    $I->assertTrue($rule->passes('!"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~'));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheBetweenValidationRule(UnitTester $I): void
  {
    $min = 1;
    $max = 10;
    $rule = new BetweenValidationRule($min, $max);

    $I->assertTrue($rule->passes(5));
    $I->assertFalse($rule->passes(1));
    $I->assertFalse($rule->passes(11));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheDateValidationRule(UnitTester $I): void
  {
    $rule = new DateValidationRule();

    $I->assertTrue($rule->passes("2022-01-01", 'Y-m-d'));
    $I->assertTrue($rule->passes("2022/01/01", 'Y/d/m'));
    $I->assertTrue($rule->passes("01-01-2022", 'd-m-Y'));
    $I->assertTrue($rule->passes("Jan 1, 2022", 'M j, Y'));
    $I->assertTrue($rule->passes("2022-13-01", 'Y-d-m'));
    $I->assertFalse($rule->passes("2022-01-32", 'Y-m-d'));
    $I->assertFalse($rule->passes("2022-02-29", 'Y-m-d'));
    $I->assertTrue($rule->passes("2020-02-29", 'Y-m-d'));
    $I->assertTrue($rule->passes("January 1, 2022 12:00:00", 'F j, Y h:i:s'));
    $I->assertTrue($rule->passes("2022-01-01T12:00:00Z"));
    $I->assertTrue($rule->passes("2022-01-01T12:00:00+05:00"));
    $I->assertFalse($rule->passes("not a date"));
    $I->assertTrue($rule->passes(123456789));
    $I->assertFalse($rule->passes([2022, 01, 01]));
    $I->assertTrue($rule->passes([01, 01, 2022]));
    $I->assertTrue($rule->passes([12, 31, 2000]));
    $I->assertFalse($rule->passes([2, 29, 2001]));
    $I->assertTrue($rule->passes('{"year": 2022, "month": 1, "day": 1}'));
    $I->assertFalse($rule->passes('{"year": 2022, "month": 01, "day": 01}'));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheDomainNameValidationRule(UnitTester $I): void
  {
    $rule = new DomainNameValidationRule();

    $I->assertTrue($rule->passes('google.com'));
    $I->assertTrue($rule->passes('example.com'));
    $I->assertTrue($rule->passes('example.co.uk'));
    $I->assertTrue($rule->passes('www.example.co.uk'));

    $I->assertFalse($rule->passes('www.example'));
    $I->assertFalse($rule->passes('blog.assegaiphp'));
    $I->assertFalse($rule->passes('notadomain'));
    $I->assertFalse($rule->passes('example'));
  }

  public function checkTheEmailValidationRule(UnitTester $I): void
  {
    $validEmail = 'assegaiphp@gmail.com';
    $invalidEmail = 'assegaiphp';
    $emptyEmail = '';

    $rule = new EmailValidationRule();

    $I->assertTrue($rule->passes($validEmail));
    $I->assertFalse($rule->passes($invalidEmail));
    $I->assertFalse($rule->passes($emptyEmail));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheEmptyValidationRule(UnitTester $I): void
  {
    $rule = new EmptyValidationRule();

    $I->assertTrue($rule->passes(null));
    $I->assertTrue($rule->passes(''));
    $I->assertTrue($rule->passes([]));
    $I->assertFalse($rule->passes(0));
    $I->assertFalse($rule->passes('0'));
    $I->assertFalse($rule->passes('null'));
    $I->assertFalse($rule->passes(false));
    $I->assertFalse($rule->passes(true));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheEnumValidationRule(UnitTester $I): void
  {
    $rule = new EnumValidationRule(MockEnum::class);
    $I->assertTrue($rule->passes(MockEnum::A));
    $I->assertTrue($rule->passes('B'));
    $I->assertFalse($rule->passes('G'));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheEqualToValidationRule(UnitTester $I): void
  {
    $value = 100;

    $rule = new EqualToValidationRule($value);

    $I->assertTrue($rule->passes($value));
    $I->assertFalse($rule->passes(99));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheInListValidationRule(UnitTester $I): void
  {
    $list = [1, 2, 3, 5, 8, 13, 21];
    $validValue = 5;
    $inValidValue = 100;

    $rule = new InListValidationRule($list);

    $I->assertTrue($rule->passes($validValue));
    $I->assertFalse($rule->passes($inValidValue));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheIntegerValidationRule(UnitTester $I): void
  {
    $validValue = 1;
    $floatValue = 9.8;
    $stringValue = '1';
    $boolValue = false;
    $arrayValue = ['name' => 'John Doe', 'age' => 33];
    $objectValue = (object)$arrayValue;

    $rule = new IntegerValidationRule();

    $I->assertTrue($rule->passes($validValue));
    $I->assertFalse($rule->passes($floatValue));
    $I->assertFalse($rule->passes($stringValue));
    $I->assertFalse($rule->passes($boolValue));
    $I->assertFalse($rule->passes($arrayValue));
    $I->assertFalse($rule->passes($objectValue));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheJsonValidationRule(UnitTester $I): void
  {
    $rule = new JsonValidationRule();

    $I->assertTrue($rule->passes('{ "test": { "foo": "bar" } }'));
    $I->assertTrue($rule->passes('{"name": "John", "age": 30, "city": "New York"}'));
    $I->assertTrue($rule->passes('{}'));
    $I->assertTrue($rule->passes('{"name": null, "age": 30, "city": "New York"}'));
    $I->assertTrue($rule->passes('{"person": {"name": "John", "age": 30}, "city": "New York"}'));
    $I->assertTrue($rule->passes('{"name": "John", "age": 30, "city": ["New York", "London", "Paris"]}'));
    $I->assertTrue($rule->passes('{"name": "John", "age": 30, "city": ["New York", 123, true]}'));
    $I->assertFalse($rule->passes('{{"name": "John", "age": 30, "city": "New York"}!!'));
    $I->assertFalse($rule->passes('{ "": "": "" } }'));
    $I->assertFalse($rule->passes('{name: "John", age: 30, city: "New York"}'));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheMaxLengthValidationRule(UnitTester $I): void
  {
    $maxLength = 16;
    $shortText = 'Hello World!';
    $longText = 'The quick brown fox jumps over the lazy dog!';
    $integerValue = 1024;
    $floatValue = 9.8;
    $boolValue = false;
    $arrayValue = ['name' => 'John Doe', 'age' => 33];
    $objectValue = (object)$arrayValue;

    $rule = new MaxLengthValidationRule($maxLength);
    $I->assertTrue($rule->passes($shortText));
    $I->assertFalse($rule->passes($longText));
    $I->assertFalse($rule->passes($integerValue));
    $I->assertFalse($rule->passes($floatValue));
    $I->assertFalse($rule->passes($boolValue));
    $I->assertFalse($rule->passes($objectValue));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheMaxValidationRule(UnitTester $I): void
  {
    $max = 100;
    $validValue = 99;
    $invalidValue = 101;
    $validFloatValue = 9.8;
    $invalidFloatValue = 105.1;
    $validNumericStringValue = '1';
    $invalidNumericStringValue = '101';
    $invalidStringValue = 'fadfawe';
    $boolValue = false;
    $arrayValue = ['name' => 'John Doe', 'age' => 33];
    $objectValue = (object)$arrayValue;

    $rule = new MaxValidationRule($max);

    $I->assertTrue($rule->passes($validValue));
    $I->assertFalse($rule->passes($invalidValue));
    $I->assertTrue($rule->passes($validFloatValue));
    $I->assertFalse($rule->passes($invalidFloatValue));
    $I->assertTrue($rule->passes($validNumericStringValue));
    $I->assertFalse($rule->passes($invalidNumericStringValue));
    $I->assertFalse($rule->passes($invalidStringValue));
    $I->assertFalse($rule->passes($boolValue));
    $I->assertFalse($rule->passes($objectValue));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheMinLengthValidationRule(UnitTester $I): void
  {
    $minLength = 20;
    $shortText = 'Hello World!';
    $longText = 'The quick brown fox jumps over the lazy dog!';
    $integerValue = 1024;
    $floatValue = 9.8;
    $boolValue = false;
    $arrayValue = ['name' => 'John Doe', 'age' => 33];
    $objectValue = (object)$arrayValue;

    $rule = new MinLengthValidationRule($minLength);
    $I->assertTrue($rule->passes($longText));
    $I->assertFalse($rule->passes($shortText));
    $I->assertFalse($rule->passes($integerValue));
    $I->assertFalse($rule->passes($floatValue));
    $I->assertFalse($rule->passes($boolValue));
    $I->assertFalse($rule->passes($objectValue));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheMinValidationRule(UnitTester $I): void
  {
    $min = 100;
    $validValue = 101;
    $invalidValue = 99;
    $validFloatValue = 100.1;
    $invalidFloatValue = 99.1;
    $validNumericStringValue = '101';
    $invalidNumericStringValue = '99';
    $invalidStringValue = 'fadfawe';
    $boolValue = false;
    $arrayValue = ['name' => 'John Doe', 'age' => 33];
    $objectValue = (object)$arrayValue;

    $rule = new MinValidationRule($min);

    $I->assertTrue($rule->passes($validValue));
    $I->assertFalse($rule->passes($invalidValue));
    $I->assertTrue($rule->passes($validFloatValue));
    $I->assertFalse($rule->passes($invalidFloatValue));
    $I->assertTrue($rule->passes($validNumericStringValue));
    $I->assertFalse($rule->passes($invalidNumericStringValue));
    $I->assertFalse($rule->passes($invalidStringValue));
    $I->assertFalse($rule->passes($boolValue));
    $I->assertFalse($rule->passes($objectValue));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheNotEmptyValidationRule(UnitTester $I): void
  {
    $rule = new NotEmptyValidationRule();

    $I->assertTrue($rule->passes('1, 2 unbuckle my shoe'));
    $I->assertTrue($rule->passes([1,2,3,4]));
    $I->assertTrue($rule->passes((object)['name' => 'John Doe', 'age' => 50]));
    $I->assertTrue($rule->passes(true));
    $I->assertTrue($rule->passes(false));
    $I->assertFalse($rule->passes([]));
    $I->assertFalse($rule->passes(''));
    $I->assertFalse($rule->passes(null));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheNotEqualToValidationRule(UnitTester $I): void
  {
    $stringTarget = 'I am the target';
    $numericTarget = 100;
    $boolTarget = true;
    $arrayTarget = [1, 1, 6];

    $rule = new NotEqualToValidationRule($stringTarget);

    $validStringValue = 'ahdfasdfasd';
    $invalidStringValue = $stringTarget;

    $I->assertTrue($rule->passes($validStringValue));
    $I->assertFalse($rule->passes($invalidStringValue));

    $rule = new NotEqualToValidationRule($numericTarget);
    $validNumericValue = !$numericTarget;
    $invalidNumericValue = $numericTarget;
    $I->assertTrue($rule->passes($validNumericValue));
    $I->assertFalse($rule->passes($invalidNumericValue));

    $rule = new NotEqualToValidationRule($boolTarget);
    $validBoolValue = -90;
    $invalidBoolValue = $boolTarget;
    $I->assertTrue($rule->passes($validBoolValue));
    $I->assertFalse($rule->passes($invalidBoolValue));

    $rule = new NotEqualToValidationRule($arrayTarget);
    $validArrayValue = [9, 1, 1];
    $invalidArrayValue = $arrayTarget;
    $I->assertTrue($rule->passes($validArrayValue));
    $I->assertFalse($rule->passes($invalidArrayValue));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheNotInListValidationRule(UnitTester $I): void
  {
    $list = [1, 2, 3];
    $rule = new NotInListValidationRule($list);

    $validValue = 4;
    $invalidValue = 2;

    $I->assertTrue($rule->passes($validValue));
    $I->assertFalse($rule->passes($invalidValue));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheNumberValidationRule(UnitTester $I): void
  {
    $rule = new NumberValidationRule();
    $integerValue = 1;
    $floatValue = 11.6;
    $numericString = '10';
    $stringValue = 'hello assegai';
    $boolValue = true;
    $arrayValue = [1,2,3];

    $I->assertTrue($rule->passes($integerValue));
    $I->assertTrue($rule->passes($floatValue));
    $I->assertFalse($rule->passes($stringValue));
    $I->assertFalse($rule->passes($numericString));
    $I->assertFalse($rule->passes($boolValue));
    $I->assertFalse($rule->passes($arrayValue));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheNumericValidationRule(UnitTester $I): void
  {
    $rule = new NumericValidationRule();
    $integerValue = 1;
    $floatValue = 11.6;
    $stringValue = 'hello assegai';
    $boolValue = true;
    $arrayValue = [1,2,3];

    $I->assertTrue($rule->passes($integerValue));
    $I->assertTrue($rule->passes($floatValue));
    $I->assertFalse($rule->passes($stringValue));
    $I->assertFalse($rule->passes($boolValue));
    $I->assertFalse($rule->passes($arrayValue));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkThePhoneNumberValidationRule(UnitTester $I): void
  {
    $regionCode = 'ZM';
    $rule = new PhoneNumberValidationRule($regionCode);

    $I->assertTrue($rule->passes("+260 211 000 000"));
    $I->assertTrue($rule->passes("+260 0966 123 000"));
    $I->assertTrue($rule->passes("+260 0977 456 000"));
    $I->assertTrue($rule->passes("260 0955 456 000"));
    $I->assertTrue($rule->passes("0955 456 000"));
    $I->assertFalse($rule->passes("+1 650 253 0000"));

    $regionCode = "CH";
    $rule = new PhoneNumberValidationRule($regionCode);
    $I->assertTrue($rule->passes("044 668 18 00"));
    $I->assertFalse($rule->passes("+260 211 000 000"));

    $regionCode = "US";
    $rule = new PhoneNumberValidationRule($regionCode);
    $I->assertTrue($rule->passes("+1 650 253 0000"));
    $I->assertFalse($rule->passes("+260 211 000 000"));

    $regionCode = "GB";
    $rule = new PhoneNumberValidationRule($regionCode);
    $I->assertTrue($rule->passes("0161 496 0000"));
    $I->assertFalse($rule->passes("+260 211 000 000"));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheRegexValidationRule(UnitTester $I): void
  {
    $regex = '/^[a-z]+$/i';
    $rule = new RegexValidationRule($regex);

    $I->assertTrue($rule->passes('abc'));
    $I->assertFalse($rule->passes('abc1'));

    $regex = '/^[0-9]+$/i';
    $rule = new RegexValidationRule($regex);

    $I->assertTrue($rule->passes('1234'));
    $I->assertFalse($rule->passes('a1b2c3'));

    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheRequiredValidationRule(UnitTester $I): void
  {
    $rule = new RequiredValidationRule();

    $validValue = 'This is valid';

    $I->assertTrue($rule->passes($validValue));
    $I->assertFalse($rule->passes(''));
    $I->assertFalse($rule->passes(null));
    $I->assertTrue($rule->passes(false));
    $I->assertTrue($rule->passes(0));
    $I->assertFalse($rule->passes([]));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheStringValidationRule(UnitTester $I): void
  {
    $rule = new StringValidationRule();

    $validString = 'This is a valid string';
    $I->assertTrue($rule->passes($validString));

    $validString = "This is a valid string";
    $I->assertTrue($rule->passes($validString));
    $validString = <<<EOF
    This is a valid string
    EOF;
    $I->assertTrue($rule->passes($validString));

    $validString = <<<'EOF'
    This is a valid string
    EOF;
    $I->assertTrue($rule->passes($validString));

    $validStringable = new MockStringable();
    $I->assertFalse($rule->passes($validStringable));

    $validStringable = new MockText();
    $I->assertFalse($rule->passes($validStringable));

    $integerValue = 1;
    $floatValue = 1.0;
    $boolValue = true;
    $arrayValue = ['name' => 'Steven'];
    $objectValue = (object)$arrayValue;
    $callableValue = function() { return 'This is a string'; };

    $I->assertFalse($rule->passes($integerValue));
    $I->assertFalse($rule->passes($floatValue));
    $I->assertFalse($rule->passes($boolValue));
    $I->assertFalse($rule->passes($arrayValue));
    $I->assertFalse($rule->passes($objectValue));
    $I->assertFalse($rule->passes($callableValue));
    $I->assertNotEmpty($rule->getErrorMessage());
  }

  public function checkTheUrlValidationRule(UnitTester $I): void
  {
    $rule = new URLValidationRule();

    $validURL = 'https://example.com';
    $I->assertTrue($rule->passes($validURL));

    $validURL = 'http://example.com';
    $I->assertTrue($rule->passes($validURL));

    $validURL = '//example.com';
    $I->assertFalse($rule->passes($validURL));

    $validURL = 'example.com';
    $I->assertFalse($rule->passes($validURL));
  }
}
