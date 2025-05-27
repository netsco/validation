# Laravel Pint Configuration

This document explains how to use Laravel Pint for code style enforcement in the Rakit Validation project.

## What is Laravel Pint?

Laravel Pint is a PHP code style fixer for minimalists, powered by PHP-CS-Fixer. It provides a simple way to ensure that your code style stays clean and consistent.

## Configuration

The project uses a `pint.json` file in the root directory to configure Laravel Pint. The configuration simply uses the PSR-12 preset:

```json
{
    "preset": "psr12"
}
```

This preset enforces PSR-12 coding standards without any additional customizations.

## Running Laravel Pint

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

## PSR-12 Compliance

The configuration enforces PSR-12 coding standards, which is an extension of PSR-1 and PSR-2. Key aspects include:

1. Files MUST use only UTF-8 without BOM for PHP code
2. Files SHOULD either declare symbols (classes, functions, constants, etc.) or cause side-effects (e.g. generate output, change .ini settings, etc.) but SHOULD NOT do both
3. Namespace and class declarations follow PSR-0 and PSR-4
4. Class opening braces MUST go on the next line, and closing braces MUST go on the next line after the body
5. Method opening braces MUST go on the next line, and closing braces MUST go on the next line after the body
6. Visibility MUST be declared on all properties and methods
7. All PHP keywords MUST be in lowercase
8. The PHP constants `true`, `false`, and `null` MUST be in lowercase

## Adding to Composer Scripts

For convenience, you can add Laravel Pint to your Composer scripts in `composer.json`:

```json
{
    "scripts": {
        "pint": "pint",
        "pint:test": "pint --test"
    }
}
```

Then you can run:

```bash
composer pint
```

or

```bash
composer pint:test
```

## Integration with CI/CD

Laravel Pint can be integrated into your CI/CD pipeline to ensure code style consistency. Add the following step to your CI configuration:

```yaml
- name: Check code style
  run: vendor/bin/pint --test
```

This will fail the build if there are any code style issues.
