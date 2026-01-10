<?php

declare(strict_types=1);

namespace Tests\Unit\Builders;

use Posternak\Commandeer\Builders\PHPStan;

final class PHPStanTest extends BuilderTestCase {
    public static function expectedCommands(): \Iterator
    {
        yield [
            PHPStan::analyse()->_vv(),
            'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'phpstan' . ' analyse -vv'
        ];
    }
}
