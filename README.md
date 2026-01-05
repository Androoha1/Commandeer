# Commandeer

A fluent PHP library for building and executing shell commands programmatically.

## Installation

```bash
composer require posternak/commandeer
```

Requires PHP 8.1 or higher.

## Overview

Commandeer provides a type-safe, fluent API for constructing and executing shell commands in PHP, replacing error-prone string concatenation with chainable method calls.

## ShellCommand Class

The foundation class that executes commands and captures results:

```php
use Posternak\Commandeer\ShellCommand;

$command = new ShellCommand('git status');
$command->run();

if ($command->succeeded()) {
    $output = $command->getOutput(); // array of lines
}
```

**API:**
- `run(): self` - Execute the command
- `succeeded(): bool` - Check if exit code was 0
- `getOutput(): array` - Get output lines
- `getCommand(): string` - Get command string

## Cmd Builder - Universal Command Builder

Build any command fluently using the `Cmd` class:

```php
use Posternak\Commandeer\Builders\Cmd;

// The static method name becomes the executable
Cmd::docker()->ps()->_a()->run();
Cmd::kubectl()->get('pods')->_o('json')->run();
Cmd::npm()->install()->run();

// Method chaining builds the command
// Underscores convert to dashes for options
Cmd::git()->log()->pretty('oneline')->run(); // git log --pretty oneline
```

**API:**
- `Cmd::{executable}()` - Start building a command for any executable
- `->{method}()` - Add command arguments (underscores become dashes)
- `->run()` - Execute the command
- `->getCommand()` - Preview command string without executing

## Predefined Builders

For commonly-used tools, predefined builders eliminate the need to specify the executable name:

```php
use Posternak\Commandeer\Builders\Git;
use Posternak\Commandeer\Builders\Composer;

// Instead of Cmd::git()
Git::status()->porcelain()->run();

// Instead of Cmd::composer()
Composer::require('vendor/package')->run();
```

**Available builders:** `Git`, `Composer`, `Rector`, `PHPStan`, `PHPCsFixer`, `Php`, `Artisan`

## Git Convenience Methods

The Git builder includes shortcuts for common operations:

```php
Git::addEverything(); // git add .
Git::commitWithMessage('feat: add feature'); // git commit -m "..."
Git::pushToOrigin('main'); // git push origin main
```

## License

MIT
