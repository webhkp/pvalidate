<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;

#[Attribute]
class Range extends ValidationRule {
    public function __construct(
        readonly private ?float $min = null,
        readonly private ?float $max = null,
        readonly private bool $notEqual = false,
    ) {

    }

    public function isValid(): bool {
        return match (true) {
            ($this->min !== null && $this->notEqual && $this->value <= $this->min) => false,
            ($this->min !== null && !$this->notEqual && $this->value < $this->min) => false,
            ($this->max !== null && $this->notEqual && $this->value >= $this->max) => false,
            ($this->max !== null && !$this->notEqual && $this->value > $this->max) => false,
            default => true
        };
    }

    public function getErrors(): array {
        $errors = [];

        $equalToPhrase = ($this->notEqual ? '' : 'or equal to');

        if ($this->isMinFailure()) {
            $errors['min'] = "{$this->name} should be larger than {$equalToPhrase} {$this->min}";
        }

        if ($this->isMaxFailure()) {
            $errors['max'] = "{$this->name} should be smaller than {$equalToPhrase} {$this->max}";
        }

        return $errors;
    }

    private function isMinFailure(): bool {
        return match (true) {
            ($this->min !== null && $this->notEqual && $this->value <= $this->min) => true,
            ($this->min !== null && !$this->notEqual && $this->value < $this->min) => true,
            default => false
        };
    }

    private function isMaxFailure(): bool {
        return match (true) {
            ($this->max !== null && $this->notEqual && $this->value >= $this->max) => true,
            ($this->max !== null && !$this->notEqual && $this->value > $this->max) => true,
            default => false
        };
    }
}