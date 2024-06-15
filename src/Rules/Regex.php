<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Regex extends ValidationRule {
    public function __construct(private readonly string $regex) {

    }

    public function isValid(): bool {
        if (!preg_match($this->regex, $this->value)) {
            return false;
        }

        return true;
    }

    public function getErrors(): array {
        $errors = [];

        if (!$this->isValid()) {
            $errors['regex'] = $this->name . ' should match the regex \'' . $this->regex . '\'';
        }

        return $errors;
    }

    
}