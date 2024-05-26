<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use ReflectionProperty;
use ReflectionEnum;
use Webhkp\Pvalidate\Enums\ValidationRuleType;
use Webhkp\Pvalidate\Exceptions\PvalidateException;

/**
 * Abstract Validator
 * Used by all validators
 */
abstract class ValidationRule {
    protected ?string $name = '';

    protected $value = null;

    public function getName(): string {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

    /**
     * Apply validation
     *
     * @param ReflectionProperty $prop
     * @param object $object
     * @return ValidationRule
     */
    public function apply(ReflectionProperty $prop, object $object): ValidationRule {
        $this->value = $prop->getValue($object);
        $this->name = $prop->name;

        return $this;
    }

    /**
     * Parse and set result
     *
     * @param $value
     * @return ValidationRule
     */
    public function safeParse($value): ValidationRule {
        $this->value = $value;

        return $this;
    }

    /**
     * Parse and throw exception if there is error
     *
     * @param $value
     * @return ValidationRule
     */
    public function parse($value): ValidationRule {
        $this->value = $value;
        
        if (!$this->isValid()) {
            $className = explode('\\', static::class);
            $className = end($className);
            
            if (!in_array($className, array_map(fn($case) => $case->name, (new ReflectionEnum(ValidationRuleType::class))->getCases()))) {
                $className = ValidationRuleType::Custom->name;
            }

            throw new PvalidateException(current($this->getErrors()), ValidationRuleType::{$className});
        }

        return $this;
    }
    
    /**
     * Check if data is valid for the rule
     *
     * @return boolean
     */
    abstract public function isValid(): bool;

    /**
     * Get errors for this validation
     *
     * @return array
     */
    abstract public function getErrors(): array;
}