<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate;

use Webhkp\Pvalidate\Validation\ValidationResponse;
use Webhkp\Pvalidate\Validation\Validators\ObjectValidator;

class Validator {
    public static function validate(object $object, ?array $array = null, ?string $json = null, ?string $yaml = null): ValidationResponse {
        return match(true) {
            $array !== null => self::validateArray($object, $array),
            $json !== null => self::validateJson($object, $json),
            $yaml !== null => self::validateYaml($object, $yaml),
            default => self::validateObject($object),
        };
    }

    public static function validateObject(object $object): ValidationResponse {
        $validator = new ObjectValidator($object);
        return $validator->validate();
    }

    public static function validateArray(object $object, array $array): ValidationResponse {

    }

    public static function validateJson(object $object, string $json): ValidationResponse {

    }

    public static function validateYaml(object $object, string $yaml): ValidationResponse {

    }
}