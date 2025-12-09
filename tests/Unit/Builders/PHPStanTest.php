<?php

declare(strict_types=1);

namespace Builders;

use Posternak\Commandeer\Builders\PHPStan;
use Tests\Unit\Builders\BuilderTestCase;

class PHPStanTest extends BuilderTestCase {
    public static function expectedCommands(): array
    {
        return [
            [
                PHPStan::analyse()->_vv(),
                'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'phpstan' . ' analyse -vv'
            ],
        ];
    }
}
