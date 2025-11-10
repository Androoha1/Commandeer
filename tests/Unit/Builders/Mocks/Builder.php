<?php

declare(strict_types=1);

namespace Tests\Unit\Builders\Mocks;

use Posternak\Commandeer\Builders\Builder as PosternakBuilder;

abstract class Builder extends PosternakBuilder {
    protected bool $hasRun = true;
}
