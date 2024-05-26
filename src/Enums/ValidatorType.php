<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Enums;


enum ValidatorType {
    case Array;
    case Object;
    case Json;
    case Yaml;
}