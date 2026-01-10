<?php

declare(strict_types=1);

namespace Tests\Unit\Builders;

use Posternak\Commandeer\Builders\Artisan;

final class ArtisanTest extends BuilderTestCase {
    public static function expectedCommands(): array
    {
        return [
            [
                Artisan::migrate(),
                'php artisan migrate',
            ],
        ];
    }
}
