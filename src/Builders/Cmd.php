<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Builders;

final class Cmd extends Builder {
    public static function __callStatic(string $method, array $args): self {
        return new self('', $args, $method);
    }
}
