<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Validation\Validators;

use Webhkp\Pvalidate\Validation\ValidationResponse;


class ArrayValidator implements BaseValidator {
    public function validate(): ValidationResponse {
        

        return new ValidationResponse([]);
    }
}