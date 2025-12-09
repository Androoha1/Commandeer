<?php

declare(strict_types=1);

namespace Builders;

use Posternak\Commandeer\Builders\Rector;
use Tests\Unit\Builders\BuilderTestCase;

class RectorTest extends BuilderTestCase {
    public static function expectedCommands(): array
    {
        return [
            [
                Rector::process(),
                'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'rector' . ' process'
            ],
        ];
    }
}
