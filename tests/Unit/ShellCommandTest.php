<?php

declare(strict_types=1);

namespace Tests\Unit;

use Posternak\Commandeer\ShellCommand;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ShellCommandTest extends TestCase {
    #[Test]
    public function appendsStringToCommand(): void {
        $command = new ShellCommand();
        $command->appendToCommand('someString', '');

        $this->assertSame('someString', $command->getCommand());
    }
}
