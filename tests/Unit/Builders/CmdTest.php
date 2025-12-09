<?php

declare(strict_types=1);

namespace Builders;

use Posternak\Commandeer\Builders\Cmd;
use Tests\Unit\Builders\BuilderTestCase;

class CmdTest extends BuilderTestCase {
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
