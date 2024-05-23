<?php

namespace Webhkp\Pvalidate\Validators;

use Attribute;
use ReflectionProperty;
use Webhkp\Pvalidate\Interfaces\ValidationRule;

#[Attribute]
class Range extends AbstractValidator {
    public function __construct(
        readonly private ?float $min = null,
        readonly private ?float $max = null
    ) {

    }

    public function validate(ReflectionProperty $prop, object $object): AbstractValidator {
        $value = $prop->getValue($object);

        if ($this->min !== null && $value < $this->min) {
            $this->valid = false;

            $this->errors['min'] = $prop->name . ' should be larger than or equal to ' . $this->min;
        }

        if ($this->max !== null && $value > $this->max) {
            $this->valid = false;

            $this->errors['max'] = $prop->name . ' should be smaller than or equal to ' . $this->max;
        }

        return $this;
    }
}