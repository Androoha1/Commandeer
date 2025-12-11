<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Shell;

class ShellOutput {
    public static function welcome(): void {
        Printer::newLine();
        self::welcomeAsciiArt();
        Printer::coloredLine("- Welcome to Commandeer Interactive Shell!", Color::SOFT_BLUE);
        Printer::coloredLine("- hint: Type 'help' if you are new to it.", Color::SOFT_BLUE);
        Printer::newLine();
    }

    private static function welcomeAsciiArt(): void {
        Printer::coloredLine(" ██████╗ ██████╗ ███╗   ███╗███╗   ███╗ █████╗ ███╗   ██╗██████╗ ███████╗███████╗██████╗ ", Color::SOFT_BLUE);
        Printer::coloredLine("██╔════╝██╔═══██╗████╗ ████║████╗ ████║██╔══██╗████╗  ██║██╔══██╗██╔════╝██╔════╝██╔══██╗", Color::SOFT_BLUE);
        Printer::coloredLine("██║     ██║   ██║██╔████╔██║██╔████╔██║███████║██╔██╗ ██║██║  ██║█████╗  █████╗  ██████╔╝", Color::SOFT_BLUE);
        Printer::coloredLine("██║     ██║   ██║██║╚██╔╝██║██║╚██╔╝██║██╔══██║██║╚██╗██║██║  ██║██╔══╝  ██╔══╝  ██╔══██╗", Color::SOFT_BLUE);
        Printer::coloredLine("╚██████╗╚██████╔╝██║ ╚═╝ ██║██║ ╚═╝ ██║██║  ██║██║ ╚████║██████╔╝███████╗███████╗██║  ██║", Color::SOFT_BLUE);
        Printer::coloredLine(" ╚═════╝ ╚═════╝ ╚═╝     ╚═╝╚═╝     ╚═╝╚═╝  ╚═╝╚═╝  ╚═══╝╚═════╝ ╚══════╝╚══════╝╚═╝  ╚═╝", Color::SOFT_BLUE);
        Printer::coloredLine("                                                                  by Andrii Posternak.", Color::GRAY);
    }

    public static function error(string $message): void {
        Printer::coloredLine("Error: {$message}", Color::RED);
    }

    public static function success(): void {
        Printer::coloredLine("✓ Command executed successfully", Color::GREEN);
    }

    public static function modeSwitch(string $mode): void {
        Printer::coloredLine("Switched to {$mode} mode", Color::YELLOW);
        Printer::line($mode === 'exec'
            ? "Commands will now execute immediately."
            : "Commands will be previewed without execution.");
    }

    public static function cancelled(): void {
        Printer::coloredLine("Cancelled", Color::GRAY);
    }

    public static function help(string $currentMode): void {
        Printer::newLine();
        Printer::coloredText("You are currently in ", Color::GRAY);
        Printer::coloredText($currentMode, Color::YELLOW);
        Printer::coloredLine(" mode", Color::GRAY);
        Printer::newLine();

        Printer::coloredLine("- Modes:", Color::SOFT_BLUE);
        Printer::coloredText("  ·preview", Color::YELLOW);
        Printer::line("  - Build commands and preview without execution");
        Printer::coloredText("  ·exec", Color::YELLOW);
        Printer::line("     - Execute commands immediately and show output");
        Printer::newLine();

        Printer::coloredLine("- Commands:", Color::SOFT_BLUE);
        Printer::coloredText("  ·mode", Color::YELLOW);
        Printer::line("     - Switch the current shell mode");
        Printer::coloredText("  ·help", Color::YELLOW);
        Printer::line("     - Display this help message");
        Printer::coloredText("  ·clear", Color::YELLOW);
        Printer::line("    - Clear the screen");
        Printer::coloredText("  ·cd", Color::YELLOW);
        Printer::line("       - Change working directory");
        Printer::coloredText("  ·exit", Color::YELLOW);
        Printer::line("     - Exit the shell");
        Printer::newLine();

        Printer::coloredLine("- Available builders:", Color::SOFT_BLUE);
        Printer::line("  Git, Cmd, Composer, Artisan, PHPStan, Rector, Php, PHPCsFixer");
        Printer::newLine();
    }

    public static function goodbye(): void {
        Printer::coloredLine("Goodbye! Go and write some nice script!", Color::CYAN);
    }
}
