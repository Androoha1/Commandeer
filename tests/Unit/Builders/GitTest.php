<?php

declare(strict_types=1);

namespace Tests\Unit\Facades;

use Posternak\Commandeer\Facades\Facade;
use Posternak\Commandeer\Facades\Git;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class GitTest extends TestCase {
    #[Test]
    #[DataProvider('dataForTest')]
    public function fluentApiCraftsCorrectCommand(Facade $instance, $expectedCommand): void {
        Git::fake();
        $this->assertSame($expectedCommand, $instance->getCommand());
    }

    public static function dataForTest(): array
    {
        return [
            [
                Git::checkout('main'),
                'git checkout main'
            ],
            [
                Git::checkout()->b('someNewBranch'),
                'git checkout -b someNewBranch'
            ],
            [
                Git::checkoutNewBranch('someNewBranch'),
                'git checkout -b someNewBranch'
            ],
            [
                Git::add('.'),
                'git add .'
            ],
            [
                Git::addEverything(),
                'git add .'
            ],
            [
                Git::commit()->message('message'),
                'git commit --message "message"'
            ],
            [
                Git::commitWithMessage('message'),
                'git commit --message "message"'
            ],
        ];
    }
}
