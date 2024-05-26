<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use ReflectionProperty;
use Webhkp\Pvalidate\Enums\ValidationRuleType;
use Webhkp\Pvalidate\Exceptions\PvalidateException;

/**
 * Abstract Validator
 * Used by all validators
 */
abstract class ValidationRule {
    protected ?string $name = '';

    protected $value = null;

    // /**
    //  * Undocumented variable
    //  *
    //  * @var boolean
    //  */
    // protected bool $valid = true;

    // /**
    //  * Undocumented variable
    //  *
    //  * @var array
    //  */
    // protected array $errors = [];

    public function getName(): string {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

    /**
     * Undocumented function
     *
     * @param ReflectionProperty $prop
     * @param object $object
     * @return ValidationRule
     */
    public function apply(ReflectionProperty $prop, object $object): ValidationRule {
        $this->value = $prop->getValue($object);
        $this->name = $prop->name;

        // $this->process();

        return $this;
    }

    public function safeParse($value): ValidationRule {
        $this->value = $value;

        return $this;
    }

    public function parse($value): ValidationRule {
        $this->value = $value;
        
        if (!$this->isValid()) {
            $className = explode('\\', static::class);
            $className = end($className);

            throw new PvalidateException(current($this->getErrors()), ValidationRuleType::{$className});
        }

        return $this;
    }
    
    /**
     * Undocumented function
     *
     * @return boolean
     */
    abstract public function isValid(): bool;

    /**
     * Undocumented function
     *
     * @return array
     */
    abstract public function getErrors(): array;
}