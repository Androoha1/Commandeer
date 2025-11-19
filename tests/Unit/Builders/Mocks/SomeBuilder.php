<?php

declare(strict_types=1);

namespace Tests\Unit\Builders\Mocks;

/**
 * @method self __another_option(string $value)
 * @method self _b(string $value)
 * @method static self someCommand(string ...$args)
 * @method static self some_command(string ...$args)
 * @method self __some_option(string $value)
 */
final class SomeBuilder extends Builder {
}
