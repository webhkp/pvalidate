<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;
use ReflectionProperty;

#[Attribute]
class Range extends AbstractRule {
    public function __construct(
        readonly private ?float $min = null,
        readonly private ?float $max = null
    ) {

    }

    public function apply(ReflectionProperty $prop, object $object): static {
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