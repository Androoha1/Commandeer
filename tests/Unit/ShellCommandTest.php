<?php

declare(strict_types=1);

namespace Tests\Unit;

use Posternak\Commandeer\ShellCommand;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ShellCommandTest extends TestCase {
    #[Test]
    public function appendsStringToCommand(): void {
        $shellCommand = new ShellCommand();
        $shellCommand->appendToCommand('someString', '');

        $this->assertSame('someString', $shellCommand->getCommand());
    }
}
