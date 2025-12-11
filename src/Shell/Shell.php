<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Shell;

use Posternak\Commandeer\Builders\Builder;
use Posternak\Commandeer\ShellCommand;
use Throwable;

class Shell {
    private string $mode = 'preview';
    private const array MODES = ['preview', 'exec'];

    /**
     * The main REPL loop.
     */
    public function run(): void {
        ShellOutput::welcome();
        Builder::fake();

        while (true) {
            $input = $this->readline($this->getPrompt());

            if ($input === false || in_array($input, ['exit', 'quit'], true)) {
                ShellOutput::goodbye();
                break;
            }

            $input = trim($input);

            if ($input === '' || $this->handleSpecialCommand($input)) {
                continue;
            }

            try {
                $this->displayResult($this->evaluate($input));
            } catch (Throwable $e) {
                ShellOutput::error($e->getMessage());
            }
        }
    }

    private function getPrompt(): string {
        return $this->mode === 'preview' ? 'preview-mode> ' : getcwd() . '> ';
    }

    private function handleSpecialCommand(string $input): bool {
        // Handle cd command
        if (str_starts_with($input, 'cd ')) {
            $path = trim(substr($input, 3));
            if (chdir($path)) {
                return true;
            } else {
                ShellOutput::error("cd: no such directory: {$path}");
                return true;
            }
        }

        return match($input) {
            'mode' => $this->selectMode(),
            'help' => $this->showHelp(),
            'clear' => $this->clearScreen(),
            default => false,
        };
    }

    private function showHelp(): bool {
        ShellOutput::help($this->mode);
        return true;
    }

    private function selectMode(): bool {
        $currentIndex = array_search($this->mode, self::MODES);
        $selectedIndex = $currentIndex;

        echo "\033[33mSelect mode:\033[0m\n";
        foreach (self::MODES as $index => $mode) {
            echo "  " . ($index + 1) . ") {$mode}" . ($index === $currentIndex ? " (current)" : "") . "\n";
        }
        echo "Enter number (1-" . count(self::MODES) . ") or press Enter to cancel: ";

        $input = trim(fgets(STDIN));

        if ($input === '') {
            ShellOutput::cancelled();
            return true;
        }

        $selection = (int)$input;

        if ($selection < 1 || $selection > count(self::MODES)) {
            ShellOutput::error("Invalid selection");
            return true;
        }

        $newMode = self::MODES[$selection - 1];
        if ($newMode !== $this->mode) {
            $this->mode = $newMode;
            ShellOutput::modeSwitch($newMode);
        }

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
                ShellOutput::success();
            }
        } elseif (is_string($result)) {
            echo $result . "\n";
        } elseif (is_array($result)) {
            print_r($result);
        } else {
            var_dump($result);
        }
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
