<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Disallow extends ValidationRule {
    public function __construct(private readonly array $disallowed) {
    }

    public function isValid(): bool {
        if (in_array($this->value, $this->disallowed)) {
            return false;
        }

        return true;
    }

    public function getErrors(): array {
        $errors = [];

        if (!$this->isValid()) {
            $errors['disallowed'] = $this->name . ' should not be in the disallowed list (' . implode(',', $this->disallowed) . ')';
        }

        return $errors;
    }
}