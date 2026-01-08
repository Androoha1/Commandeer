<?php

declare(strict_types=1);

namespace Posternak\Commandeer;

use RuntimeException;

final class ShellCommand {
    private string $command = '';
    /** @var list<string> */
    private array $output = [];
    private int $result_code = 0;
    /** @var list<int>  */
    private array $acceptableExitCodes = [0];

    public function __construct(string $command = '') {
        $this->command = $command;
    }

    /**
     * @param list<int> $codes
     */
    public function setAcceptableExitCodes(array $codes): self {
        $this->acceptableExitCodes = $codes;
        return $this;
    }

    /**
     * @return list<string>
     */
    public function getOutput(): array {
        return $this->output;
    }

    /**
     * @throws RuntimeException
     */
    public function run(): self {
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

    public function getExitCode(): int {
        return $this->result_code;
    }

    public function getCommand(): string {
        return $this->command;
    }

    public function appendToCommand(string $append, string $separator = ' '): void {
        if ($append !== '') {
            $this->command .= $separator . $append;
        }
    }
}
