<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Shell;

class Printer {
    public static function coloredText(string $text, Color $color): void {
        echo $color->value . $text . Color::RESET->value;
    }

    public static function line(string $text = ''): void {
        echo $text . "\n";
    }

    public static function coloredLine(string $text, Color $color): void {
        echo $color->value . $text . Color::RESET->value . "\n";
    }

    public static function newLine(): void {
        echo "\n";
    }
}
