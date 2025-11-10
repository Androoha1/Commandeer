<?php

declare(strict_types=1);

namespace Tests\Unit\Builders\Mocks;

/**
 * @method static self someCommand(string ...$args)
 */
final class BuilderWithOverriddenExecutableName extends Builder {
    protected static function getExecutableName(): string
    {
        return 'overriddenName';
    }
}
