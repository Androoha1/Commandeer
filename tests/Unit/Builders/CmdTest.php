<?php

declare(strict_types=1);

namespace Tests\Unit\Builders;

use Posternak\Commandeer\Builders\Cmd;

final class CmdTest extends BuilderTestCase {
    public static function expectedCommands(): array
    {
        return [
            [
                Cmd::someExecutable()->someCommand()->__someOption('optionArg'),
                'someExecutable someCommand --someOption optionArg',
            ],
            [
                Cmd::docker()->info(),
                'docker info'
            ],
        ];
    }
}
