# Code Style Guidelines

This document provides guidelines for maintaining consistent code style in the Rakit Validation project.

## Tools

The project uses three main tools for enforcing code style:

1. **PHP_CodeSniffer** - For checking code against coding standards
2. **Rector** - For automated code refactoring and standardization
3. **Laravel Pint** - For PHP code style fixing based on PHP-CS-Fixer

## PHP_CodeSniffer Rules

The project follows PSR-12 coding standards with additional rules for:

- Consistent naming conventions
- Consistent spacing
- Consistent commenting
- Consistent code structure
- Consistent formatting

### Running PHP_CodeSniffer

To check your code against the defined standards:

```bash
vendor/bin/phpcs
```

To automatically fix some issues:

```bash
vendor/bin/phpcbf
```

## Rector Rules

Rector is configured with rules for:

- Consistent naming conventions
  - Renaming parameters to match types
  - Renaming variables to match method call return types
  - Renaming properties to match types

- Consistent type declarations
  - Adding return type declarations
  - Adding parameter type declarations
  - Adding property type declarations

- Consistent coding style
  - Adding var constant comments
  - Making inherited method visibility same as parent
  - Using consistent implode syntax
  - Simplifying nullable comparisons
  - Simplifying quote escaping

### Running Rector

To check what changes Rector would make without actually changing files:

```bash
composer rector:dry-run
```

To apply the changes:

```bash
composer rector
```

## Implementing Task 4: Standardize Code Style

Task 4 from the improvement tasks list focuses on standardizing code style across the codebase. To implement this task:

1. Run PHP_CodeSniffer to identify code style issues:
   ```bash
   vendor/bin/phpcs
   ```

2. Fix simple issues automatically:
   ```bash
   vendor/bin/phpcbf
   ```

3. Run Rector to identify and fix more complex issues:
   ```bash
   composer rector:dry-run
   composer rector
   ```

4. Manually fix any remaining issues that couldn't be automatically fixed.

## Adding New Rules

### Adding PHP_CodeSniffer Rules

To add new PHP_CodeSniffer rules, edit the `phpcs.xml` file and add new `<rule>` elements:

```xml
<rule ref="Standard.Category.RuleName"/>
```

### Adding Rector Rules

To add new Rector rules, edit the `rector.php` file and add new rules to the `withRules` method:

```php
->withRules([
    // Existing rules...

    // New rule
    NewRuleClass::class,
])
```

## Laravel Pint Rules

Laravel Pint is configured with the PSR-12 preset only:

```json
{
    "preset": "psr12"
}
```

This preset enforces PSR-12 coding standards without any additional customizations.

### Running Laravel Pint

To check your code against the defined standards:

```bash
vendor/bin/pint --test
```

To automatically fix code style issues:

```bash
vendor/bin/pint
```

To fix code style issues in a specific file or directory:

```bash
vendor/bin/pint path/to/file/or/directory
```

### Adding Laravel Pint Rules

To add new Laravel Pint rules, edit the `pint.json` file in the root directory. Currently, the configuration only uses the PSR-12 preset:

```json
{
    "preset": "psr12"
}
```

If you want to add custom rules, you can add a "rules" section:

```json
{
    "preset": "psr12",
    "rules": {
        "rule_name": true
    }
}
```

For more detailed information about Laravel Pint, see [docs/pint.md](pint.md).

## Best Practices

1. **Run tools regularly**: Run PHP_CodeSniffer, Rector, and Laravel Pint regularly during development to catch style issues early.

2. **Fix issues incrementally**: If there are many issues, fix them incrementally, focusing on one type of issue at a time.

3. **Commit style changes separately**: Keep style changes in separate commits from functional changes to make code reviews easier.

4. **Document exceptions**: If a particular piece of code needs to deviate from the standard, document the reason with a comment.
