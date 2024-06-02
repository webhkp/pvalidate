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
    private static array $rules = [];

    private const RULE_NAMESPACE = 'Webhkp\Pvalidate\Rules';

    private function __construct() {

    }

    public function __call(string $name, array $arguments): static {
        return self::processValidationBuilding($name, $arguments);
    }

    public static function __callStatic(string $name, array $arguments): static {
        return self::processValidationBuilding($name, $arguments);
    }

    private static function processValidationBuilding(string $functionName, array $arguments): static {
        if (self::$builder === null) {
            self::$builder = new ValidationBuilder();
        }

        $rule = self::RULE_NAMESPACE . '\\' . ucfirst($functionName);

        if (class_exists($rule)) {
            self::$rules[$functionName] = new $rule(...$arguments);
        }

        return self::$builder;
    }

    public function parse(mixed $data): ValidationResponse {
        $validationResult = [];

        foreach (self::$rules as $key => $rule) {
            $parseResult = $rule->safeParse($data);

            $validationResult[$key] = [
                'value' => $parseResult->getValue(),
                'valid' => $parseResult->isValid(),
                'errors' => $parseResult->getErrors(),
            ];

        }

        return new ValidationResponse($validationResult);
    }
}