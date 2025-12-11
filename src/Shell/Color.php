<?php

declare(strict_types=1);

namespace Posternak\Commandeer\Shell;

enum Color: string {
    case SOFT_BLUE = "\033[38;5;67m";
    case CYAN = "\033[36m";
    case YELLOW = "\033[93m";
    case GREEN = "\033[32m";
    case RED = "\033[31m";
    case GRAY = "\033[90m";
    case ORANGE = "\033[38;5;208m";
    case PURPLE = "\033[38;5;141m";
    case WHITE = "\033[97m";
    case RESET = "\033[0m";
}
