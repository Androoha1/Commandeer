<?php

declare(strict_types=1);

namespace Tests\Unit\Facades\Mocks;

use Posternak\Commandeer\Facades\Facade as AutomationToolFacade;

abstract class Facade extends AutomationToolFacade {
    protected bool $hasRun = true;
}
