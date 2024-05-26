<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Enums;


enum ValidationRuleType: int {
    case None = 0;
    case Required = 1;
    case Range = 2;
    case Allow = 3;
    case Disallow = 4;
    case Regex = 5;
}