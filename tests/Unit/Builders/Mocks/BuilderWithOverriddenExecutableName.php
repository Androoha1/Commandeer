<?php

declare(strict_types=1);

namespace Tests\Unit\Builders\Mocks;

use Posternak\Commandeer\Builders\Builder;

/**
 * @method static self someCommand(string ...$args)
 */
final class BuilderWithOverriddenExecutableName extends Builder {
    protected bool $hasRun = true;

    protected static function getExecutableName(): string
    {
        return 'overriddenName';
    }
}
