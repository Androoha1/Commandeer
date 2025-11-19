<?php declare(strict_types=1);

namespace Posternak\Commandeer\Builders;

/**
 * @method static self test()
 */
class Artisan extends Builder {
    protected static function getExecutableName(): string
    {
        return 'php artisan';
    }
}
