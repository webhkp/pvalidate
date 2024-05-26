<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Validation;


class ValidationResponse {
    public function __construct(
        readonly private array $validationResult = []
    ) {
    }

    public function isValid(): bool {
        return !((bool) count($this->getErrors()));
    }

    public function getResult(): array {
        return $this->validationResult;
    }

    public function getErrors(): array {
        return array_filter($this->validationResult, fn($result) => $result['valid'] === false);
    }

    public function getMessages(): array {
        return array_reduce($this->getErrors(), fn($acc, $curr) => [...$acc, ...array_values($curr['errors'])], []);
    }
}