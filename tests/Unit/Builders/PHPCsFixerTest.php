<?php

declare(strict_types=1);

namespace Builders;

use Posternak\Commandeer\Builders\PHPCsFixer;
use Tests\Unit\Builders\BuilderTestCase;

class PHPCsFixerTest extends BuilderTestCase {
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
