<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Facades;

/**
 * @method static self analyse()
 */
final class PHPStan extends Facade {
    protected static function getExecutableName(): string
    {
        return 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'phpstan';
    }
}