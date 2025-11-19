<?php

declare(strict_types=1);

namespace Posternak\Commandeer;

use RuntimeException;

final class ShellCommand {
    private string $command = '';
    private array $output = [];
    private int $result_code = 0;

    public function __construct(string $command = '') {
        $this->command = $command;
    }
    public function getOutput(): array {
        return $this->output;
    }

    /**
     * @throws RuntimeException
     */
    public function run(): self {
        exec($this->command, $this->output, $this->result_code);
        if ($this->result_code !== 0) {
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
        return $this->result_code === 0;
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
