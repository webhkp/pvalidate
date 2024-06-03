<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate;

use Webhkp\Pvalidate\Validation\ValidationResponse;

class ValidationBuilder {
    private static ?ValidationBuilder $builder = null;

    /**
     * List of rules applied for this builder
     *
     * @var array Array of ValidationRule
     */
    private array $rules = [];

    private const RULE_NAMESPACE = 'Webhkp\Pvalidate\Rules';

    private function __construct() {

    }

    public function __call(string $name, array $arguments): self {
        return self::processValidationBuilding($name, $arguments, $this);
    }

    public static function __callStatic(string $name, array $arguments): self {
        return self::processValidationBuilding($name, $arguments);
    }

    private static function processValidationBuilding(string $functionName, array $arguments, ?ValidationBuilder $instance = null): self {
        if (!$instance) {
            $instance = new ValidationBuilder();
        }

        $rule = self::RULE_NAMESPACE . '\\' . ucfirst($functionName);

        if (class_exists($rule)) {
            $instance->rules[$functionName] = new $rule(...$arguments);
        } else {
            throw new \Exception("Rule not found: {$rule}");
        }

        return $instance;
    }

    public function parse(mixed $data): ValidationResponse {
        return $this->processParsing($data);
    }

    public function safeParse(mixed $data): ValidationResponse {
        return $this->processParsing($data, true);
    }

    private function processParsing(mixed $data, bool $markSafe = false): ValidationResponse {
        $validationResult = [];

        foreach ($this->rules as $key => $rule) {
            $parseResult = $markSafe ? $rule->safeParse($data) : $rule->parse($data);

            $validationResult[$key] = [
                'value' => $parseResult->getValue(),
                'valid' => $parseResult->isValid(),
                'errors' => $parseResult->getErrors(),
            ];
        }

        return new ValidationResponse($validationResult);
    }
}