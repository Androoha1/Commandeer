<?php

declare(strict_types=1);

namespace Tests\Unit\Builders;

use Posternak\Commandeer\Builders\Builder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

abstract class BuilderTestCase extends TestCase {
    #[Test]
    #[DataProvider('expectedCommands')]
    public function fluentApiCraftsCorrectCommand(Builder $instance, $expectedCommand): void {
        Builder::fake();
        $this->assertSame($expectedCommand, $instance->getCommand());
    }

    /**
     * @return array<array{Builder, string}>
     */
    abstract public static function expectedCommands(): array;
}
