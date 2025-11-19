<?php

declare(strict_types=1);

namespace Tests\Unit\Builders;

use Posternak\Commandeer\Builders\Git;

class GitTest extends BuilderTestCase {
    public static function expectedCommands(): array
    {
        return [
            [
                Git::checkout('main'),
                'git checkout main'
            ],
            [
                Git::checkout()->_b('someNewBranch'),
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
