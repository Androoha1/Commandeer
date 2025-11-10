<?php

declare(strict_types=1);

namespace Tests\Unit\Builders\Mocks;

final class BuilderWithOverriddenExecutableName extends Builder {
    protected static function getExecutableName(): string
    {
        return 'overriddenName';
    }
}
