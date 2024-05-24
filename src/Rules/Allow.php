<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;
use ReflectionProperty;

#[Attribute]
class Allow extends AbstractRule {
    public function __construct(private readonly array $allowed = []) {

    }

    public function apply(ReflectionProperty $prop, object $object): static {
        $value = $prop->getValue($object);

        if (!in_array($value, $this->allowed)) {
            $this->valid = false;

            $this->errors['allowed'] = $prop->name . ' should be in the allowed list (' . implode(',', $this->allowed) . ')';
        }

        return $this;
    }
}