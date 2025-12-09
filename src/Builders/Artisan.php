<?php declare(strict_types=1);

namespace Posternak\Commandeer\Builders;

/**
 * @method static self test()
 * @method static self migrate()
 */
class Artisan extends Builder {
    protected ?string $executableName = 'php artisan';
}
