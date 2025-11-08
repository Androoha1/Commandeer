<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Facades;

final class Rector extends Facade {
    protected static function getExecutableName(): string
    {
        return 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'rector';
    }
}