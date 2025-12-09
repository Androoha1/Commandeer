<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Builders;

/**
 * @method static self process()
 * @method self __only(string $ruleName)
 * @method __clear_cache()
 */
final class Rector extends Builder {
    protected ?string $executableName = 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'rector';
}
