<?php

declare(strict_types=1);

namespace Tests\Unit\Builders\Mocks;

use Posternak\Commandeer\Builders\Builder;

/**
 * @method self __another_option(...$args)
 * @method static self someCommand(...$args)
 * @method static self some_command(...$args)
 * @method self __some_option(...$args)
 */
final class SomeBuilder extends Builder {
    protected bool $hasRun = true;
}
