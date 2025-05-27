# Rakit Validation - Development Guidelines

This document provides guidelines and information for developers working on the Rakit Validation project.

## Build/Configuration Instructions

### Requirements
- PHP 8.0 or higher
- Composer for dependency management
- ext-mbstring PHP extension

### Installation

1. Clone the repository
2. Install dependencies:
   ```
   composer install
   ```

## Testing Information

### Running Tests

The project uses PHPUnit for testing. You can run tests using the following command:

```
composer test
```

This will run both PHPUnit tests and PHP CodeSniffer checks.

To run only PHPUnit tests:

```
vendor/bin/phpunit
```

To run only PHP CodeSniffer checks:

```
vendor/bin/phpcs
```

### Adding New Tests

1. Tests should be placed in the `tests` directory
2. Tests for validation rules should be placed in the `tests/Rules` directory
3. Test classes should extend `PHPUnit\Framework\TestCase`
4. Use data providers for testing multiple scenarios
5. Follow the existing test structure and naming conventions

### Example Test

Here's a simple example of a test for the Required validation rule:

```php
<?php

namespace Rakit\Validation\Tests;

use Rakit\Validation\Rules\Required;
use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
    /**
     * @var Required
     */
    protected $validator;

    protected function setUp(): void
    {
        $this->validator = new Required();
    }

    /**
     * @dataProvider validValuesProvider
     */
    public function testValidValues($value): void
    {
        $this->assertTrue(
            $this->validator->check($value)
        );
    }

    public function validValuesProvider(): array
    {
        return [
            ['some string'],
            [123],
            [0],
            [false],
            [[1, 2, 3]],
        ];
    }

    /**
     * @dataProvider invalidValuesProvider
     */
    public function testInvalidValues($value): void
    {
        $this->assertFalse(
            $this->validator->check($value)
        );
    }

    public function invalidValuesProvider(): array
    {
        return [
            [''],
            [null],
            [[]],
        ];
    }
}
```

## Code Style and Standards

### Coding Standards

The project follows PSR-2 coding standards. The PHP CodeSniffer configuration is defined in `phpcs.xml`:

- PSR-2 rules are enforced
- Long array syntax (using `array()` instead of `[]`) is disallowed
- Both `src` and `tests` directories are checked

### Code Refactoring with Rector

The project uses Rector for automated code refactoring. The configuration is defined in `rector.php`:

- It processes both `src` and `tests` directories
- It removes unused imports
- It applies several prepared sets of refactoring rules:
  - deadCode: removes dead code
  - codeQuality: improves code quality
  - codingStyle: enforces coding style
  - typeDeclarations: adds type declarations
  - privatization: makes properties and methods private when possible
  - earlyReturn: refactors code to use early returns
  - strictBooleans: enforces strict boolean comparisons

To run Rector:

```
composer rector
```

To run Rector in dry-run mode (to see what changes would be made without actually making them):

```
composer rector:dry-run
```

## Creating Custom Validation Rules

To create a custom validation rule:

1. Create a class that extends `Rakit\Validation\Rule`
2. Implement the `check($value)` method that returns a boolean
3. Set the `$message` property for the default error message
4. Set the `$fillableParams` property for parameters that can be filled

Example:

```php
<?php

use Rakit\Validation\Rule;

class YourCustomRule extends Rule
{
    protected $message = ":attribute is invalid";
    protected $fillableParams = ['param1', 'param2'];

    public function check($value): bool
    {
        // Implement your validation logic here
        return true; // or false if validation fails
    }
}
```

Then register your rule with the validator:

```php
$validator = new Validator();
$validator->addValidator('your_rule_name', new YourCustomRule());
```

## PHP Version Compatibility

The project supports PHP 8.0 and higher, including PHP 8.1, 8.2, 8.3, and 8.4. The code is regularly tested against these PHP versions to ensure compatibility.
