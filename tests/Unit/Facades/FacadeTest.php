<?php

declare(strict_types=1);

namespace Tests\Unit\Facades;

use Posternak\Commandeer\Facades\Facade;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Facades\Mocks\SomeFacade;
use Tests\Unit\Facades\Mocks\FacadeWithOverriddenExecutableName;

class FacadeTest extends TestCase {
    #[Test]
    #[DataProvider('dataForTest')]
    public function fluentApiCraftsCorrectCommand(Facade $instance, $expectedCommand): void {
        $this->assertSame($expectedCommand, $instance->getCommand());
    }

    #[Test]
    public function getsOverriddenExecutableName(): void {
        $this->assertSame('overriddenName someCommand', FacadeWithOverriddenExecutableName::someCommand()->getCommand());
    }

    public static function dataForTest(): array
    {
        return [
            [
                SomeFacade::someCommand(),
                'somefacade someCommand',
            ],
            [
                SomeFacade::someCommand('commandArg')->some_option('someArg')->another_option('anotherArg'),
                'somefacade someCommand commandArg --some-option someArg --another-option anotherArg',
            ],
            [
                SomeFacade::someCommand()->b('someArg'),
                'somefacade someCommand -b someArg',
            ],
            [
                SomeFacade::some_command(),
                'somefacade some-command',
            ]
        ];
    }
}
