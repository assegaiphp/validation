<?php

namespace Assegai\Validation;

use Assegai\Validation\Attributes\ValidationAttribute;
use Assegai\Validation\Interfaces\IValidationRule;
use Assegai\Validation\Rules\AlphaNumericValidationRule;
use Assegai\Validation\Rules\AlphaValidationRule;
use Assegai\Validation\Rules\BetweenValidationRule;
use Assegai\Validation\Rules\DomainNameValidationRule;
use Assegai\Validation\Rules\EmailValidationRule;
use Assegai\Validation\Rules\EqualToValidationRule;
use Assegai\Validation\Rules\InListValidationRule;
use Assegai\Validation\Rules\IntegerValidationRule;
use Assegai\Validation\Rules\MaxLengthValidationRule;
use Assegai\Validation\Rules\MaxValidationRule;
use Assegai\Validation\Rules\MinLengthValidationRule;
use Assegai\Validation\Rules\MinValidationRule;
use Assegai\Validation\Rules\NotEqualToValidationRule;
use Assegai\Validation\Rules\NotInListValidationRule;
use Assegai\Validation\Rules\NumericValidationRule;
use Assegai\Validation\Rules\RegexValidationRule;
use Assegai\Validation\Rules\RequiredValidationRule;
use Assegai\Validation\Rules\StringValidationRule;
use Assegai\Validation\Rules\URLValidationRule;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * Class Validator. This class is used to validate data against a set of rules.
 */
class Validator
{
  /**
   * @var string[] $errors
   */
  protected array $errors = [];

  /**
   * @var array|string[] $builtInRules The built-in validation rules.
   */
  protected readonly array $builtInRules;

  /**
   * Constructs a new instance of the Validator class.
   *
   * @var array|IValidationRule[] $rules The validation rules.
   */
  public function __construct(protected array $rules = [])
  {
    $this->builtInRules = [
      'alpha' => AlphaValidationRule::class,
      'alphaNum' => AlphaNumericValidationRule::class,
      'between' => BetweenValidationRule::class,
      'domain' => DomainNameValidationRule::class,
      'email' => EmailValidationRule::class,
      'equalTo' => EqualToValidationRule::class,
      'inList' => InListValidationRule::class,
      'integer' => IntegerValidationRule::class,
      'maxLength' => MaxLengthValidationRule::class,
      'max' => MaxValidationRule::class,
      'minLength' => MinLengthValidationRule::class,
      'min' => MinValidationRule::class,
      'notEqualTo' => NotEqualToValidationRule::class,
      'notInList' => NotInListValidationRule::class,
      'numeric' => NumericValidationRule::class,
      'regex' => RegexValidationRule::class,
      'required' => RequiredValidationRule::class,
      'string' => StringValidationRule::class,
      'url' => URLValidationRule::class,
    ];

    $this->rules = array_merge($this->builtInRules, $this->rules);
  }

  /**
   * Adds the given validation rule to the validator.
   *
   * @param string $name The name of the validation rule.
   * @param IValidationRule|callable|string $rule The validation rule to add.
   * @return void
   */
  public function addRule(string $name, IValidationRule|callable|string $rule): void
  {
    $this->rules[$name] = $rule;
  }

  /**
   * Adds the given validation rules to the validator.
   *
   * @param array $rules
   * @return void
   */
  public function addAllRules(array $rules): void
  {
    foreach ($rules as $name => $rule)
    {
      $this->addRule($name, $rule);
    }
  }

  /**
   * Validates the given data against each rule that has been registered.
   *
   * @param mixed $value The data to be checked.
   * @param string $rules A list of validation rules.
   *
   * @return bool Returns TRUE if all the rules check out, FALSE otherwise.
   * @throws ReflectionException
   */
  public function validate(mixed $value, string $rules = ''): bool
  {
    $effectiveRules = [];

    $ruleString = $rules;
    $rules = explode('|', $rules);
    foreach ($rules as $rule)
    {
      $ruleTokens = explode(':', $rule);
      if (!$ruleTokens)
      {
        continue;
      }
      $ruleName = $ruleTokens[0];
      $ruleArgs = (count($ruleTokens) > 1) ? array_slice($ruleTokens, 1) : [];

      if (isset($this->rules[$ruleName]))
      {
        $ruleToken = $this->rules[$ruleName];

        if (is_subclass_of($ruleToken, IValidationRule::class))
        {
          $ruleReflection = new ReflectionClass($this->rules[$ruleName]);
          /** @var IValidationRule $ruleInstance */
          $ruleInstance = $ruleReflection->newInstanceArgs($ruleArgs);

          $effectiveRules[$ruleName] = $ruleInstance;
        }
      }
    }

    /** @var IValidationRule $rule */
    foreach ($effectiveRules as $field => $rule)
    {
      if (!$rule->passes($value))
      {
        $this->errors[$field] = $rule->getErrorMessage();
      }
    }

    return $this->passes();
  }

  /**
   * Indicates whether validation was successful.
   *
   * @return bool Returns TRUE if all rule checks passed, otherwise FALSE.
   */
  public function passes(): bool
  {
    return empty($this->getErrors());
  }

  /**
   * Indicates whether any validation rule failed.
   *
   * @return bool Returns TRUE if any rule check failed, otherwise FALSE.
   */
  public function fails(): bool
  {
    return !empty($this->getErrors());
  }

  /**
   * Returns a list of validation errors that were encountered during the validation process.
   *
   * @return string[] Returns a list of validation errors that were encountered during the validation process.
   */
  public function getErrors(): array
  {
    return $this->errors;
  }

  /**
   * @param string|object $classOrObject
   * @param array $errors
   * @return bool
   * @throws ReflectionException
   */
  public static function validateClass(string|object $classOrObject, array &$errors = []): bool
  {
    $classReflection = new ReflectionClass($classOrObject);

    foreach ($classReflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property)
    {
      if (self::propertyHasValidationAttributes($property))
      {
        $errorList = [];
        self::propertyPasses($property, $errorList);
        $errors = array_merge($errors, $errorList);
      }
    }

    return empty($errors);
  }

  /**
   * Determines whether the given property has validation attributes.
   *
   * @param ReflectionProperty $property The property to check.
   * @return bool Returns TRUE if the property has validation attributes, otherwise FALSE.
   */
  protected static function propertyHasValidationAttributes(ReflectionProperty $property): bool
  {
    $attributes = $property->getAttributes();

    foreach ($attributes as $attribute)
    {
      if (is_subclass_of($attribute->getName(), ValidationAttribute::class))
      {
        return true;
      }
    }

    return false;
  }

  /**
   * Validates the given property.
   *
   * @param ReflectionProperty $property The property to validate.
   * @param array $errors The list of errors.
   * @return bool Returns TRUE if the property passes validation, otherwise FALSE.
   */
  protected static function propertyPasses(ReflectionProperty $property, array &$errors = []): bool
  {
    $errors = [];

    foreach ($property->getAttributes() as $attribute)
    {
      if (is_subclass_of($attribute->getName(), ValidationAttribute::class))
      {
        $attributeInstance = $attribute->newInstance();
        if (!$attributeInstance->getRule()->passes($property->getValue(new $property->class)))
        {
          $errors[] = $attributeInstance->getRule()->getErrorMessage();
        }
      }
    }

    return empty($errors);
  }
}