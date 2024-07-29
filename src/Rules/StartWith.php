<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class StartWith extends ValidationRule {
    public function __construct(
        readonly private ?string $checkStr = null,
        readonly private ?bool $ignoreCase = false,
    ) {

    }

    public function isValid(): bool {
        if (!$this->checkStr) {
            return true;
        }

        if ($this->ignoreCase) {
            return str_starts_with(strtolower($this->value), strtolower($this->checkStr));
        }

        return str_starts_with($this->value, $this->checkStr);
    }

    public function getErrors(): array {
        $errors = [];

        if (!$this->isValid()) {
            $errors['startWith'] = "({$this->value}) does not start with ({$this->checkStr})";
        }

        return $errors;
    }
}