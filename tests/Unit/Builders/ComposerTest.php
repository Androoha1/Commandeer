<?php

declare(strict_types=1);

namespace Tests\Unit\Builders;

use Posternak\Commandeer\Builders\Composer;

final class ComposerTest extends BuilderTestCase {
    public static function expectedCommands(): \Iterator
    {
        yield [
            Composer::require('vendor1/package1', 'vendor2/package2'),
            'composer require vendor1/package1 vendor2/package2',
        ];
        yield [
            Composer::require('vendor1/package1', 'vendor2/package2')->__dev(),
            'composer require vendor1/package1 vendor2/package2 --dev',
        ];
    }
}
