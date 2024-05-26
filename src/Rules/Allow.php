<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;

#[Attribute]
class Allow extends ValidationRule {
    /**
     * Undocumented function
     *
     * @param array $allowed
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