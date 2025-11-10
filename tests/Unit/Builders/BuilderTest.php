<?php

declare(strict_types=1);

namespace Tests\Unit\Builders;

use Posternak\Commandeer\Builders\Builder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Builders\Mocks\SomeBuilder;
use Tests\Unit\Builders\Mocks\BuilderWithOverriddenExecutableName;

class BuilderTest extends TestCase {
    #[Test]
    #[DataProvider('dataForTest')]
    public function fluentApiCraftsCorrectCommand(Builder $instance, $expectedCommand): void {
        $this->assertSame($expectedCommand, $instance->getCommand());
    }

    #[Test]
    public function getsOverriddenExecutableName(): void {
        $this->assertSame('overriddenName someCommand', BuilderWithOverriddenExecutableName::someCommand()->getCommand());
    }

    public static function dataForTest(): array
    {
        return [
            [
                SomeBuilder::someCommand(),
                'somebuilder someCommand',
            ],
            [
                SomeBuilder::someCommand('commandArg')->some_option('someArg')->another_option('anotherArg'),
                'somebuilder someCommand commandArg --some-option someArg --another-option anotherArg',
            ],
            [
                SomeBuilder::someCommand()->b('someArg'),
                'somebuilder someCommand -b someArg',
            ],
            [
                SomeBuilder::some_command(),
                'somebuilder some-command',
            ]
        ];
    }
}
