<?php

declare(strict_types=1);

namespace Posternak\Commandeer;

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

    public function run(): self {
        exec($this->command, $this->output, $this->result_code);
        return $this;
    }

    public function succeeded(): bool {
        return $this->result_code === 0;
    }

    public function getCommand(): string {
        return $this->command;
    }

    public function appendToCommand(string $append, string $separator = ' '): void {
        $this->command .= $separator . $append;
    }
}
