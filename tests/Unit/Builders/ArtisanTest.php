<?php

declare(strict_types=1);

namespace Builders;

use Posternak\Commandeer\Builders\Artisan;
use Tests\Unit\Builders\BuilderTestCase;

class ArtisanTest extends BuilderTestCase {
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
