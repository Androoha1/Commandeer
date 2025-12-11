<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Shell;

class ShellOutput {
        public static function welcome(): void {
            echo "\n\033[36m╔══════════════════════════════════════════════════╗\n";
            echo         "║     Welcome to Commandeer Interactive Shell!     ║\n";
            echo         "╚══════════════════════════════════════════════════╝\033[0m\n";
            echo "You are in the preview mode right now. Try crafting shell commands in php language!\n\n";
        }
}
