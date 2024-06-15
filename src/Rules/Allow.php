<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Allow extends ValidationRule {
    /**
     * Allow constructor
     *
     * @param array $allowed List of allowed values
     */
    public function __construct(private readonly array $allowed = []) {

    }

    public function isValid(): bool {
        if (!in_array($this->value, $this->allowed)) {
            return false;
        }

        return true;
    }

    public function getErrors(): array {
        $errors = [];

        if (!$this->isValid()) {
            $errors['allowed'] = $this->name . ' should be in the allowed list (' . implode(',', $this->allowed) . ')';
        }

        return $errors;
    }

    
}