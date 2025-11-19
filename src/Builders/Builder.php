<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Builders;

use Posternak\Commandeer\ShellCommand;

abstract class Builder {
    protected ShellCommand $command;
    protected bool $hasRun = false;
    private static bool $faked = false;

    final public function __construct(string $command, array $args = []) {
        $this->command = new ShellCommand(
            implode(
                ' ',
                [static::getExecutableName(), $command, ...$args]
            ),
        );
    }

    public function run(): ShellCommand {
        $this->hasRun = true;
        return $this->command->run();
    }

    public function getCommand(): string {
        return $this->command->getCommand();
    }

    public static function __callStatic(string $method, array $args): self
    {
        return new static(str_replace('_', '-', $method), $args);
    }

    public function __call(string $method, array $args): self {
        $this->command->appendToCommand(str_replace('_', '-', $method));
        $this->command->appendToCommand(implode(' ', $args));
        return $this;
    }

    protected static function getExecutableName(): string
    {
        $fullClass = static::class;
        $className = substr($fullClass, strrpos($fullClass, '\\') + 1);
        return strtolower($className);
    }

    public static function fake(): void {
        static::$faked = true;
    }

    public function __destruct() {
        if (!(self::$faked || $this->hasRun)) {
            $this->run();
        }
    }
}
