<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Length extends ValidationRule {
    public function __construct(
        readonly private ?float $min = null,
        readonly private ?float $max = null
    ) {

    }

    public function isValid(): bool {
        return match (true) {
            $this->isMinFailure() => false,
            $this->isMaxFailure() => false,
            default => true
        };
    }

    public function getErrors(): array {
        $errors = [];

        if ($this->min !== null && $this->max !== null && $this->min > $this->max) {
            $errors['wrongParam'] = "max value ({$this->max}) should be greater than or equal to min value ({$this->min})";
        } else {
            if ($this->isMinFailure()) {
                $errors['minLength'] = "{$this->name} length should be larger than or equal to {$this->min}";
            }

            if ($this->isMaxFailure()) {
                $errors['maxLength'] = "{$this->name} length should be smaller than or equal to {$this->max}";
            }
        }

        return $errors;
    }

    private function isMinFailure(): bool {
        if ($this->min !== null && strlen($this->value) < $this->min) {
            return true;
        }

        return false;
    }

    private function isMaxFailure(): bool {
        if ($this->max !== null && strlen($this->value) > $this->max) {
            return true;
        }

        return false;
    }
}