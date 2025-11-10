<?php

declare(strict_types=1);

namespace Tests\Unit\Builders\Mocks;

/**
 * @method self another_option(string $value)
 * @method self b(string $value)
 * @method static self someCommand(string ...$args)
 * @method static self some_command(string ...$args)
 * @method self some_option(string $value)
 */
final class SomeBuilder extends Builder {
}
