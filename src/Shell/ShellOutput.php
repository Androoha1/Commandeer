<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Shell;

use Posternak\ConsolePrinter\Color;
use Posternak\ConsolePrinter\Printer;

class ShellOutput {
    public function __construct(
        private readonly Printer $printer
    ) {}

    public function welcome(): void {
        $this->printer->newLine();
        $this->welcomeAsciiArt();
        $this->printer->println("- Welcome to Commandeer Interactive Shell!", [Color::SOFT_BLUE]);
        $this->printer->println("- hint: Type 'help' if you are new to it.", [Color::SOFT_BLUE]);
        $this->printer->newLine();
    }

    private function welcomeAsciiArt(): void {
        $this->printer->println(" ██████╗ ██████╗ ███╗   ███╗███╗   ███╗ █████╗ ███╗   ██╗██████╗ ███████╗███████╗██████╗ ", [Color::SOFT_BLUE]);
        $this->printer->println("██╔════╝██╔═══██╗████╗ ████║████╗ ████║██╔══██╗████╗  ██║██╔══██╗██╔════╝██╔════╝██╔══██╗", [Color::SOFT_BLUE]);
        $this->printer->println("██║     ██║   ██║██╔████╔██║██╔████╔██║███████║██╔██╗ ██║██║  ██║█████╗  █████╗  ██████╔╝", [Color::SOFT_BLUE]);
        $this->printer->println("██║     ██║   ██║██║╚██╔╝██║██║╚██╔╝██║██╔══██║██║╚██╗██║██║  ██║██╔══╝  ██╔══╝  ██╔══██╗", [Color::SOFT_BLUE]);
        $this->printer->println("╚██████╗╚██████╔╝██║ ╚═╝ ██║██║ ╚═╝ ██║██║  ██║██║ ╚████║██████╔╝███████╗███████╗██║  ██║", [Color::SOFT_BLUE]);
        $this->printer->println(" ╚═════╝ ╚═════╝ ╚═╝     ╚═╝╚═╝     ╚═╝╚═╝  ╚═╝╚═╝  ╚═══╝╚═════╝ ╚══════╝╚══════╝╚═╝  ╚═╝", [Color::SOFT_BLUE]);
        $this->printer->println("                                                                  by Andrii Posternak.", [Color::GRAY]);
    }

    public function error(string $message): void {
        $this->printer->println('Error: ' . $message, [Color::RED]);
    }

    public function success(): void {
        $this->printer->println("✓ Command executed successfully", [Color::GREEN]);
    }

    public function modeSwitch(string $mode): void {
        $this->printer->println(sprintf('Switched to %s mode', $mode), [Color::CYAN]);
        $this->printer->println($mode === 'exec'
            ? "Commands will now execute immediately."
            : "Commands will be previewed without execution.");
    }

    public function cancelled(): void {
        $this->printer->println("Cancelled", [Color::GRAY]);
    }

    public function help(string $currentMode): void {
        $this->printer->newLine();
        $this->printer->println(sprintf('{You are currently in the {%s} mode}', $currentMode), [Color::SOFT_BLUE, Color::CYAN]);
        $this->printer->newLine();

        $this->printer->println("- Modes:", [Color::CYAN]);
        $this->printer->println("  ·{preview}  - Build commands and preview without execution", [Color::SOFT_BLUE]);
        $this->printer->println("  ·{exec}     - Execute commands immediately and show output", [Color::SOFT_BLUE]);
        $this->printer->newLine();

        $this->printer->println("- Commands:", [Color::CYAN]);
        $this->printer->println("  ·{mode}     - Switch the current shell mode", [Color::SOFT_BLUE]);
        $this->printer->println("  ·{help}     - Display this help message", [Color::SOFT_BLUE]);

        if ($currentMode === 'exec') {
            $this->printer->println("  ·{cd}       - Change working directory (exec mode only)", [Color::SOFT_BLUE]);
        }

        $this->printer->println("  ·{exit}     - Exit the shell", [Color::SOFT_BLUE]);
        $this->printer->newLine();

        $this->printer->println("- Available builders:", [Color::CYAN]);
        $this->printer->println("  Git, Cmd, Composer, Artisan, PHPStan, Rector, Php, PHPCsFixer");
        $this->printer->newLine();
    }

    public function goodbye(): void {
        $this->printer->println("Goodbye! Go and write some nice script!", [Color::SOFT_BLUE]);
    }
}
