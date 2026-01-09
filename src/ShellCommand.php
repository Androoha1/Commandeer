<?php

declare(strict_types=1);

namespace Posternak\Commandeer;

use Posternak\ConsolePrinter\Color;
use Posternak\ConsolePrinter\Printer;
use RuntimeException;

final class ShellCommand {
    private string $command = '';
    
    /** @var list<string> */
    private array $output = [];
    
    private int $result_code = 0;
    
    /** @var list<int>  */
    private array $acceptableExitCodes = [0];
    
    private static bool $verbose = false;

    public function __construct(string $command = '') {
        $this->command = $command;
    }

    /**
     * @throws RuntimeException
     */
    public function run(): self {
        if (self::$verbose) {
            new Printer()->println('{Commandeer info} - Executing {' . $this->command . '}:', [Color::SOFT_BLUE, Color::YELLOW]);
        }
        
        exec($this->command, $this->output, $this->result_code);
        if (!$this->succeeded()) {
            throw new RuntimeException(
                sprintf(
                    "Command failed with exit code %d: %s\nOutput: %s",
                    $this->result_code,
                    $this->command,
                    implode("\n", $this->output)
                )
            );
        }
        
        return $this;
    }

    public function succeeded(): bool {
        return in_array($this->result_code, $this->acceptableExitCodes, true);
    }

    public function failed(): bool {
        return !$this->succeeded();
    }

    public static function setVerbose(bool $verbose): void {
        self::$verbose = $verbose;
    }

    /**
     * @param list<int> $codes
     */
    public function setAcceptableExitCodes(array $codes): self {
        $this->acceptableExitCodes = $codes;
        return $this;
    }

    public function getCommand(): string {
        return $this->command;
    }

    /**
     * @return list<string>
     */
    public function getOutput(): array {
        return $this->output;
    }

    public function getExitCode(): int {
        return $this->result_code;
    }

    public function appendToCommand(string $append, string $separator = ' '): void {
        if ($append !== '') {
            $this->command .= $separator . $append;
        }
    }
}
