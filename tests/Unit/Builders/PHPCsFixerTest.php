<?php

declare(strict_types=1);

namespace Tests\Unit\Builders;

use Posternak\Commandeer\Builders\PHPCsFixer;

final class PHPCsFixerTest extends BuilderTestCase {
    public static function expectedCommands(): array
    {
        return [
            [
                PHPCsFixer::fix(),
                'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'php-cs-fixer' . ' fix'
            ],
        ];
    }
}
