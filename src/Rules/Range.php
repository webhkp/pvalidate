<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;

#[Attribute]
class Range extends ValidationRule {
    public function __construct(
        readonly private ?float $min = null,
        readonly private ?float $max = null
    ) {

    }

    public function isValid(): bool {
        if (($this->min !== null && $this->value < $this->min)
            || ($this->max !== null && $this->value > $this->max)
        ) {
            return false;
        }

        return true;
    }

    public function getErrors(): array {
        $errors = [];

        if ($this->min !== null && $this->value < $this->min) {
            $errors['min'] = $this->name . ' should be larger than or equal to ' . $this->min;
        }

        if ($this->max !== null && $this->value > $this->max) {
            $errors['max'] = $this->name . ' should be smaller than or equal to ' . $this->max;
        }

        return $errors;
    }
}