<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Facades;

/**
 * @method static self checkout(string $branch)
 * @method static self pull()
 * @method static self add(string ...$paths)
 * @method static self push(string $remote, string $branch)
 * @method static self commit()
 * @method static status()
 */
final class Git extends Facade {
    private static string $commitMessagesPrefix = '';
    public static function checkoutNewBranch(string $branch): self {
        return self::checkout()->b($branch);
    }

    public static function addEverything(): self {
        return self::add('.');
    }

    public function message(string $message = ''): self {
        $this->command->appendToCommand('--message "' . $message . '"');
        return $this;
    }

    public static function commitWithMessage(string $message): self {
        return self::commit()->message(self::$commitMessagesPrefix . $message);
    }

    public static function addEverythingAndCommitWithMessage(string $message): self {
        self::addEverything();
        return self::commitWithMessage($message);
    }

    public static function getCurrentBranch(): string {
        return self::rev_parse()->abbrev_ref('HEAD')->run()->getOutput()[0];
    }

    public static function isWorkingTreeClean(): bool {
        return empty(Git::status()->porcelain()->run()->getOutput());
    }

    public static function hasChanges(): bool {
        return !self::isWorkingTreeClean();
    }

    public static function setCommitMessagesPrefix(string $prefix): void {
        self::$commitMessagesPrefix = $prefix;
    }
}
