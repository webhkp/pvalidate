<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;
use ReflectionProperty;

#[Attribute]
class Required extends AbstractRule {
    public function apply(ReflectionProperty $prop, object $object): static {
        if (!$prop->isInitialized($object)) {
            $this->valid = false;
        } else {
            $value = $prop->getValue($object);

            $this->valid = (bool)!empty($value);
        }

        if (!$this->valid) {
            $this->errors['required'] = $prop->name . ' is Required';
        }

        return $this;
    }
}