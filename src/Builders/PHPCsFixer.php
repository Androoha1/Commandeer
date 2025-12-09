<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Builders;

/**
 * @method static self fix(...$args)
 */
final class PHPCsFixer extends Builder {
    protected ?string $executableName = 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'php-cs-fixer';
}
