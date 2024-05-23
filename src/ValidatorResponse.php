<?php

namespace Webhkp\Pvalidate;

use ReflectionClass;
use ReflectionAttribute;
use Webhkp\Pvalidate\Validators\AbstractValidator;

class ValidatorResponse {
    public function __construct(
        readonly private bool $valid = true,
        readonly private array $errors = []
    ) {

    }

    public function isValid(): bool {
        return $this->valid;
    }

    public function getErrors(): array {
        return $this->errors;
    }
}