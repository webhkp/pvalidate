<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use ReflectionProperty;

/**
 * Abstract Validator
 * Used by all validators
 */
abstract class AbstractRule {
    protected bool $valid = true;
    protected array $errors = [];

    public function isValid(): bool {
        return $this->valid;
    }

    public function getErrors(): array { 
        return $this->errors;
    }

    abstract public function apply(ReflectionProperty $prop, object $object): AbstractRule;
}