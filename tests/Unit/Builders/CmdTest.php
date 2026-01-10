<?php

declare(strict_types=1);

namespace Tests\Unit\Builders;

use Posternak\Commandeer\Builders\Cmd;

final class CmdTest extends BuilderTestCase {
    public static function expectedCommands(): \Iterator
    {
        yield [
            Cmd::someExecutable()->someCommand()->__someOption('optionArg'),
            'someExecutable someCommand --someOption optionArg',
        ];
        yield [
            Cmd::docker()->info(),
            'docker info'
        ];
    }
}
