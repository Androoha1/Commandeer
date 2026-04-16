# Commandeer

A fluent PHP API for building and executing shell commands programmatically, for taking them under control, or in other words - commandeer them.

## Installation

Install it into your project with composer:
```bash
composer require posternak/commandeer
```

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

The `Cmd` class provides a universal interface for building any shell command, it's the fluent API. To construct a command:

1. Start with the `Cmd` class.
2. Call a static method whose name matches your desired executable (e.g., `Cmd::docker()` for the `docker` executable).
3. Chain additional methods for CLI options and arguments, passing data as method parameters.

Method names are automatically converted to command-line syntax (underscores become dashes), and method arguments become command parameters.

**Examples:**

```php
use Posternak\Commandeer\Builders\Cmd;

// docker ps -a
Cmd::docker()->ps()->_a()->run();

// kubectl get pods -o json
Cmd::kubectl()->get('pods')->_o('json')->run();

// npm install
Cmd::npm()->install()->run();

// git log --pretty oneline
Cmd::git()->log()->pretty('oneline')->run();
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

## Interactive Shell (REPL)

Commandeer ships with an interactive shell for exploring and running commands without writing a PHP script. All builder classes are available automatically — no `use` statements needed.

```bash
vendor/bin/commandeer
```

Type `help` once inside to get started.

## License

MIT
