<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;
use ReflectionProperty;

#[Attribute]
class Disallow extends AbstractRule {
    public function __construct(private readonly array $disallowed) {
    }

    public function apply(ReflectionProperty $prop, object $object): static {
        $value = $prop->getValue($object);

        if (in_array($value, $this->disallowed)) {
            $this->valid = false;

            $this->errors['disallowed'] = $prop->name . ' should not be in the disallowed list (' . implode(',', $this->disallowed) . ')';
        }

        return $this;
    }
}