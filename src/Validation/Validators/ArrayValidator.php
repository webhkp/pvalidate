<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Validation\Validators;


class ArrayValidator implements BaseValidator {
    public function validate(): ValidatorResponse {
        

        return new ValidatorResponse($validationResult);
    }
}