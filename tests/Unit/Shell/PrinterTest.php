<?php

declare(strict_types=1);

namespace Tests\Unit\Shell;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Posternak\Commandeer\Shell\Color;
use Posternak\Commandeer\Shell\Printer;

class PrinterTest extends TestCase {
    /**
     * @param list<Color> $colors
     */
    #[Test]
    #[DataProvider('dataProvider')]
    public function itCorrectlyColorsCaptureGroups(string $text, array $colors, string $correctResult): void {
        ob_start();
        new Printer()->print($text, $colors);
        $actualResult = ob_get_clean();

        $this->assertSame($correctResult, $actualResult);
    }

    #[Test]
    public function itThrowsExceptionWhenCapturingGroupsExistButNoColorsProvided(): void {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Capturing groups are defined but no colors provided');

        new Printer()->print('Some {nice} text is {written} here', []);
    }

    #[Test]
    public function itThrowsExceptionWhenMoreColorsThanCapturingGroups(): void {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Too many colors provided: 3 colors for 2 capturing groups');

        new Printer()->print('Some {nice} text is {written} here', [Color::RED, Color::YELLOW, Color::GREEN]);
    }

    /**
     * @return array<array<string|array>>
     */
    public static function dataProvider(): array {
        return [
            'No capturing groups, no colors' => [
                'Some nice text is written here',
                [],
                'Some nice text is written here',
            ],
            'No capturing groups, one color - color' => [
                'Some nice text is written here',
                [Color::YELLOW],
                Color::YELLOW->value . 'Some nice text is written here' . Color::RESET->value,
            ],
            'One capturing group, one color' => [
                'Some nice {text} is written here',
                [Color::RED],
                'Some nice ' . Color::RED->value . 'text' . Color::RESET->value .  ' is written here',
            ],
            'Two capturing groups, two colors' => [
                'Some {nice} text is {written} here',
                [Color::RED, Color::YELLOW],
                'Some ' . Color::RED->value . 'nice' . Color::RESET->value .  ' text is ' . Color::YELLOW->value . 'written' . Color::RESET->value .  ' here',
            ],
            'Two capturing groups, one color' => [
                'Some {nice} text is {written} here',
                [Color::RED],
                'Some ' . Color::RED->value . 'nice' . Color::RESET->value .  ' text is ' . Color::RED->value . 'written' . Color::RESET->value .  ' here',
            ],
        ];
    }
}
