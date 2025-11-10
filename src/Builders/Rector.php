<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Builders;

final class Rector extends Builder {
    protected static function getExecutableName(): string
    {
        return 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'rector';
    }
}