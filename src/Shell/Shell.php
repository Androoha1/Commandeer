<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Shell;

use Posternak\Commandeer\Builders\Builder;
use Posternak\Commandeer\ShellCommand;
use Posternak\ConsolePrinter\Color;
use Posternak\ConsolePrinter\Printer;
use Throwable;

class Shell {
    private string $mode = 'preview';
    
    private const array MODES = ['preview', 'exec'];

    public function __construct(
        private readonly Printer $printer,
        private readonly ShellOutput $output
    ) {}

    public function run(): void {
        $this->output->welcome();
        Builder::fake();

        while (true) {
            $input = $this->readline($this->getPrompt());

            if ($input === false || in_array($input, ['exit', 'quit'], true)) {
                $this->output->goodbye();
                break;
            }

            $input = trim($input);

            if ($input === '' || $this->handleSpecialCommand($input)) {
                continue;
            }

            try {
                $this->displayResult($this->evaluate($input));
            } catch (Throwable $e) {
                $this->output->error($e->getMessage());
            }
        }
    }

    private function getPrompt(): string {
        return $this->mode === 'preview' ? '[preview]> ' : '[' . getcwd() . ']> ';
    }

    private function handleSpecialCommand(string $input): bool {
        if (str_starts_with($input, 'cd ')) {
            if ($this->mode !== 'exec') {
                $this->output->error("cd command is only available in exec mode");
                return true;
            }

            $path = trim(substr($input, 3));
            if (chdir($path)) {
                return true;
            } else {
                $this->output->error("cd: no such directory: {$path}");
                return true;
            }
        }

        return match($input) {
            'mode' => $this->selectMode(),
            'help' => $this->showHelp(),
            default => false,
        };
    }

    private function showHelp(): bool {
        $this->output->help($this->mode);
        return true;
    }

    private function selectMode(): bool {
        $currentIndex = array_search($this->mode, self::MODES);

        $this->printer->println("Select mode:", [Color::CYAN]);
        foreach (self::MODES as $index => $mode) {
            $current = $index === $currentIndex ? " (current)" : "";
            $this->printer->println("  " . ($index + 1) . ") {$mode}$current");
        }
        
        $this->printer->print("Enter number (1-" . count(self::MODES) . ") or press Enter to cancel: ");

        $input = trim(fgets(STDIN));

        if ($input === '') {
            $this->output->cancelled();
            return true;
        }

        $selection = (int)$input;

        if ($selection < 1 || $selection > count(self::MODES)) {
            $this->output->error("Invalid selection");
            return true;
        }

        $newMode = self::MODES[$selection - 1];
        if ($newMode !== $this->mode) {
            $this->mode = $newMode;
            $this->output->modeSwitch($newMode);
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

        if ($result instanceof ShellCommand) {
            $output = $result->getOutput();
            if ($output !== []) {
                echo implode("\n", $output) . "\n";
            } else {
                $this->output->success();
            }
        } elseif (is_string($result)) {
            echo $result . "\n";
        } elseif (is_array($result)) {
            print_r($result);
        } else {
            var_dump($result);
        }
    }

    private function readline(string $prompt): string|false {
        $input = readline($prompt);
        if ($input !== false && $input !== '') {
            readline_add_history($input);
        }
        
        return $input;
    }
}
