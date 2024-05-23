<?php

namespace Webhkp\Pvalidate\Validators;

use Attribute;
use ReflectionProperty;
use Webhkp\Pvalidate\Interfaces\ValidationRule;

#[Attribute]
class Required extends AbstractValidator {
    public function validate(ReflectionProperty $prop, object $object): AbstractValidator {
        if (!$prop->isInitialized($object)) {
            $this->valid = false;
        } else {
            $value = $prop->getValue($object);

            $this->valid = !empty($value);
        }

        if (!$this->valid) {
            $this->errors['required'] = $prop->name . ' is Required';
        }

        return $this;
    }
}