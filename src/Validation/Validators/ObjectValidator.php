<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Validation\Validators;

use ReflectionClass;
use ReflectionAttribute;
use Webhkp\Pvalidate\Rules\ValidationRule;
use Webhkp\Pvalidate\Validation\ValidationResponse;


class ObjectValidator implements BaseValidator {
    public function __construct(private readonly object $object) {

    }

    public function validate(): ValidationResponse {
        $validationResult = [];

        $objReflection = new ReflectionClass($this->object);

        foreach ($objReflection->getProperties() as $prop) {
            $attribs = $prop->getAttributes(ValidationRule::class, ReflectionAttribute::IS_INSTANCEOF);

            foreach ($attribs as $attrib) {
                $result = $attrib->newInstance()->apply($prop, $this->object);

                $validationResult[$prop->name] = [
                    'value' => $prop->isInitialized($this->object) ? $prop->getValue($this->object) : null,
                    'valid' => $result->isValid(),
                    'errors' => $result->getErrors()
                ];
            }
        }

        return new ValidationResponse($validationResult);
    }
}