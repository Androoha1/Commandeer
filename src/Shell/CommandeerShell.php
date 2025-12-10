<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Shell;

use Posternak\Commandeer\Builders\Builder;
use Posternak\Commandeer\ShellCommand;
use Throwable;

class CommandeerShell {
    private string $mode = 'preview';

    public function run(): void {
        $this->printWelcome();
        Builder::fake();

        while (true) {
            $input = $this->readline($this->getPrompt());

            if ($input === false || in_array($input, ['exit', 'quit'], true)) {
                echo "Goodbye!\n";
                break;
            }

            $input = trim($input);

            if ($input === '' || $this->handleSpecialCommand($input)) {
                continue;
            }

            try {
                $this->displayResult($this->evaluate($input));
            } catch (Throwable $e) {
                echo "\033[31mError: {$e->getMessage()}\033[0m\n";
            }
        }
    }

    private function getPrompt(): string {
        return $this->mode === 'preview' ? 'preview-mode> ' : getcwd() . '> ';
    }

    private function handleSpecialCommand(string $input): bool {
        return match($input) {
            'help' => $this->showHelp(),
            'mode preview', 'mode exec' => $this->setMode(explode(' ', $input)[1]),
            'clear' => $this->clearScreen(),
            default => false,
        };
    }

    private function setMode(string $mode): bool {
        $this->mode = $mode;
        echo "\033[33mSwitched to {$mode} mode\033[0m\n";
        echo $mode === 'exec'
            ? "Commands will now execute immediately.\n"
            : "Commands will be previewed without execution.\n";
        return true;
    }

    private function evaluate(string $code): mixed {
        $useStatements = $this->generateUseStatements();

        if ($this->mode === 'exec') {
            return eval("
                {$useStatements}
                \Posternak\Commandeer\Builders\Builder::fake(false);
                \$result = {$code};
                
                if (\$result instanceof \Posternak\Commandeer\Builders\Builder) {
                    \$result = \$result->run();
                }
                
                return \$result;
            ");
        }

        return eval("{$useStatements} return {$code};");
    }

    private function generateUseStatements(): string {
        $statements = [];

        foreach (glob(__DIR__ . '/../Builders/*.php') as $file) {
            $className = basename($file, '.php');
            if ($className !== 'Builder') {
                $statements[] = "use Posternak\\Commandeer\\Builders\\{$className};";
            }
        }

        return implode("\n            ", $statements);
    }

    private function displayResult(mixed $result): void {
        if ($this->mode === 'preview') {
            if ($result instanceof Builder || $result instanceof ShellCommand) {
                $indent = str_repeat(' ', strlen($this->getPrompt()));
                echo "{$indent}\033[93m→ {$result->getCommand()}\033[0m\n";
            } elseif (is_string($result)) {
                echo $result . "\n";
            } else {
                var_dump($result);
            }
            return;
        }

        // Exec mode
        if ($result instanceof ShellCommand) {
            $output = $result->getOutput();
            if (!empty($output)) {
                echo implode("\n", $output) . "\n";
            } else {
                echo "\033[32m✓ Command executed successfully\033[0m\n";
            }
        } elseif (is_string($result)) {
            echo $result . "\n";
        } elseif (is_array($result)) {
            print_r($result);
        } else {
            var_dump($result);
        }
    }

    private function printWelcome(): void {
        echo "\033[36m╔═══════════════════════════════════════╗\n";
        echo         "║     Commandeer Interactive Shell      ║\n";
        echo         "╚═══════════════════════════════════════╝\033[0m\n\n";
        echo "Type 'help' for available commands.\n\n";
    }

    private function showHelp(): bool {
        echo "\033[33mAvailable builders:\n";

        foreach (glob(__DIR__ . '/../Builders/*.php') as $file) {
            $className = basename($file, '.php');
            if ($className !== 'Builder') {
                echo "  {$className}::\n";
            }
        }

        echo "\nExamples:\n";
        echo "  Git::status()\n";
        echo "  Cmd::docker()->ps()->_a()\n";
        echo "  Composer::install()->__dev()\n\n";

        echo "Commands:\n";
        echo "  mode preview   - Preview commands (default)\n";
        echo "  mode exec      - Execute commands immediately\n";
        echo "  clear          - Clear screen\n";
        echo "  help           - Show this help\n";
        echo "  exit           - Exit shell\033[0m\n\n";

        return true;
    }

    private function clearScreen(): bool {
        echo "\033[2J\033[H";
        return true;
    }

    private function readline(string $prompt): string|false {
        $input = readline($prompt);
        if ($input !== false && $input !== '') {
            readline_add_history($input);
        }
        return $input;
    }
}
