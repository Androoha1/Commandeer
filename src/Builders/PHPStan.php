<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Builders;

/**
 * @method static self analyse()
 */
final class PHPStan extends Builder {
    protected static function getExecutableName(): string
    {
        return 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'phpstan';
    }
}