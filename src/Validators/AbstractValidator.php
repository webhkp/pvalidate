<?php

namespace Webhkp\Pvalidate\Validators;

use Attribute;
use ReflectionProperty;

abstract class AbstractValidator {
    protected bool $valid = true;
    protected array $errors = [];

    public function isValid(): bool {
        return $this->valid;
    }

    public function getErrors(): array {
        return $this->errors;
    }

    abstract public function validate(ReflectionProperty $prop, object $object): AbstractValidator;
}