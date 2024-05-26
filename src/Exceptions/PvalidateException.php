<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Exceptions;

use Exception;
use Throwable;
use Webhkp\Pvalidate\Enums\ValidationRuleType;

class PvalidateException extends Exception {
    public function __construct(
        string $message,
        ValidationRuleType $code = ValidationRuleType::None,
        Throwable $previous = null,
        private $additionalData = null
    ) {
        parent::__construct($message, $code->value, $previous);
    }

    public function __toString(): string {
        return __CLASS__ . ": [{$this->code}] : {$this->message}\n";
    }

    public function getAdditionalData() {
        return $this->additionalData;
    }
}