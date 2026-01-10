<?php

declare(strict_types=1);

namespace Tests\Unit\Builders;

use Posternak\Commandeer\Builders\Git;

final class GitTest extends BuilderTestCase {
    public static function expectedCommands(): \Iterator
    {
        yield [
            Git::checkout('main'),
            'git checkout main'
        ];
        yield [
            Git::checkout()->_b('someNewBranch'),
            'git checkout -b someNewBranch'
        ];
        yield [
            Git::checkoutNewBranch('someNewBranch'),
            'git checkout -b someNewBranch'
        ];
        yield [
            Git::add('.'),
            'git add .'
        ];
        yield [
            Git::addEverything(),
            'git add .'
        ];
        yield [
            Git::commit()->message('message'),
            'git commit --message "message"'
        ];
        yield [
            Git::commitWithMessage('message'),
            'git commit --message "message"'
        ];
    }
}
