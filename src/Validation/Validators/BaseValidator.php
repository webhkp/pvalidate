<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Validation\Validators;

use Attribute;
use ReflectionProperty;
use Webhkp\Pvalidate\Validation\ValidationResponse;

interface BaseValidator {
    public function validate(): ValidationResponse;
}