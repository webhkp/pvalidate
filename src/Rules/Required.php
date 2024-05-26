<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;
use ReflectionProperty;

#[Attribute]
class Required extends ValidationRule {
    private ReflectionProperty $prop;
    private object $object;

    public function isValid(): bool {
        if (isset($this->prop)
            && $this->prop->isInitialized($this->object)
            && !$this->prop->isInitialized($this->object)
        ) {
            return false;
        }

        return (bool) !empty($this->value);
    }

    public function getErrors(): array {
        $errors = [];

        if (!$this->isValid()) {
            $errors['required'] = $this->name . ' field is Required';
        }

        return $errors;
    }

    public function apply(ReflectionProperty $prop, object $object): static {
        $this->value = $prop->isInitialized($object) ? $prop->getValue($object) : null;
        $this->name = $prop->name;
        $this->prop = $prop;
        $this->object = $object;

        return $this;
    }
}