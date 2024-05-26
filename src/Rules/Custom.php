<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;

#[Attribute]
class Custom extends ValidationRule {
    public function __construct($call) {
        var_dump($call); exit;
    }

    public function isValid(): bool {
        // $value = $prop->getValue($object);

        // // ($this->callable)($value, $this->valid, $this->errors);

        // return $this;
        return true;
    }

    public function getErrors(): array {
        return [];
    }
}