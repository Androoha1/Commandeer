<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Builders;

use Posternak\Commandeer\ShellCommand;
use ReflectionClass;

abstract class Builder {
    protected ?string $executableName;
    protected ShellCommand $command;
    protected bool $hasRun = false;
    protected static bool $faked = false;

    /**
     * @param list<string> $args
     */
    final public function __construct(string $command = '', array $args = [], ?string $executableName = null) {
        if ($executableName !== null) {
            $this->executableName = $executableName;
        }
        $parts = array_filter(
            [$this->getExecutableName(), $command, ...$args],
            fn($part) => $part !== ''
        );

        $this->command = new ShellCommand(implode(' ', $parts));
    }

    public function run(): ShellCommand {
        $this->hasRun = true;
        return $this->command->run();
    }

    public function getCommand(): string {
        return $this->command->getCommand();
    }

    /**
     * Get the executable name, deriving from class name if not explicitly set.
     */
    protected function getExecutableName(): string
    {
        return $this->executableName ?? strtolower(new ReflectionClass(static::class)->getShortName());
    }

    public static function fake(): void {
        static::$faked = true;
    }

    /**
     * @param list<string> $args
     */
    public function __call(string $method, array $args): self {
        $this->command->appendToCommand(str_replace('_', '-', $method));
        $this->command->appendToCommand(implode(' ', $args));
        return $this;
    }

    /**
     * @param list<string> $args
     */
    public static function __callStatic(string $method, array $args): self
    {
        return new static(str_replace('_', '-', $method), $args);
    }

    public function __destruct() {
        if (!(self::$faked || $this->hasRun)) {
            $this->run();
        }
    }
}
