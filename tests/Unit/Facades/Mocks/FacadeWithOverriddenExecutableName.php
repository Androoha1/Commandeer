<?php

declare(strict_types=1);

namespace Tests\Unit\Facades\Mocks;

final class FacadeWithOverriddenExecutableName extends Facade {
    protected static function getExecutableName(): string
    {
        return 'overriddenName';
    }
}
