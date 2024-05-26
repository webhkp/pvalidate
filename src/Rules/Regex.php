<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;
use ReflectionProperty;

#[Attribute]
class Regex extends ValidationRule {
    public function __construct(private readonly array $disallowed) {
    }

    public function isValid(): bool {
        return true;
    }

    public function getErrors(): array {
        return [];
    }
}