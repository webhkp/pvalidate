<?php

namespace Webhkp\Pvalidate;

use ReflectionClass;
use ReflectionAttribute;
use Webhkp\Pvalidate\Validators\AbstractValidator;

final class Validator {
    public static function validate(object $object): ValidatorResponse {
        $valid = true;
        $errors = [];

        $objReflection = new ReflectionClass($object);

        foreach ($objReflection->getProperties() as $prop) {
            $attribs = $prop->getAttributes(AbstractValidator::class, ReflectionAttribute::IS_INSTANCEOF);

            foreach ($attribs as $attrib) {
                $result = $attrib->newInstance()->validate($prop, $object);

                if (!$result->isValid()) {
                    $valid = false;

                    $errors[$prop->name] = $result->getErrors();
                }
            }
        }

        return new ValidatorResponse($valid, $errors);
    }
}