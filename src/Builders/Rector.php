<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Builders;

/**
 * @method static self process()
 * @method __clear_cache()
 */
final class Rector extends Builder {
    protected static function getExecutableName(): string
    {
        return 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'rector';
    }
}
