<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Builders;

/**
 * @method static self analyse(...$args)
 * @method self _vv()
 */
final class PHPStan extends Builder {
    protected ?string $executableName = 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'phpstan';
}