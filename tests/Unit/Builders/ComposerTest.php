<?php

declare(strict_types=1);

namespace Tests\Unit\Builders;

use Posternak\Commandeer\Builders\Composer;

class ComposerTest extends BuilderTestCase {
    public static function expectedCommands(): array
    {
        return [
            [
                Composer::require('vendor1/package1', 'vendor2/package2'),
                'composer require vendor1/package1 vendor2/package2',
            ],
            [
                Composer::require('vendor1/package1', 'vendor2/package2', '--dev'),
                'composer require vendor1/package1 vendor2/package2 --dev',
            ],
        ];
    }
}
