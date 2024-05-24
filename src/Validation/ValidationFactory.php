<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Validation;

use Webhkp\Pvalidate\Enums\ValidatorType;
use Webhkp\Pvalidate\Validators\ArrayValidator;
use Webhkp\Pvalidate\Validators\ObjectValidator;

class ValidationFactory {
    public static function getValidator(ValidatorType $validator) {
        return match ($validator) {
            ValidatorType::Array => ArrayValidator::class,
            default => ObjectValidator::class,
        };
    }
}