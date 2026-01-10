<?php

declare(strict_types=1);

namespace Tests\Unit\Builders;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\Builders\Mocks\SomeBuilder;
use Tests\Unit\Builders\Mocks\BuilderWithOverriddenExecutableName;

final class BuilderTest extends BuilderTestCase {
    #[Test]
    public function getsOverriddenExecutableName(): void {
        $this->assertSame('overriddenName someCommand', BuilderWithOverriddenExecutableName::someCommand()->getCommand());
    }

    public static function expectedCommands(): \Iterator
    {
        yield [
            new SomeBuilder(),
            'somebuilder',
        ];
        yield [
            SomeBuilder::someCommand(),
            'somebuilder someCommand',
        ];
        yield [
            SomeBuilder::some_command(),
            'somebuilder some-command',
        ];
        yield [
            SomeBuilder::someCommand('someArg'),
            'somebuilder someCommand someArg',
        ];
        yield [
            SomeBuilder::someCommand('someArg')->__some_option(),
            'somebuilder someCommand someArg --some-option',
        ];
        yield [
            SomeBuilder::someCommand()->__some_option('someOptionArg'),
            'somebuilder someCommand --some-option someOptionArg',
        ];
        yield [
            SomeBuilder::someCommand('someArg')->__some_option('someOptionArg')->__another_option('anotherOptionArg'),
            'somebuilder someCommand someArg --some-option someOptionArg --another-option anotherOptionArg',
        ];
    }
}
