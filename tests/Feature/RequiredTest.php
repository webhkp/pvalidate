<?php

use Webhkp\Pvalidate\Rules\Required;
use Webhkp\Pvalidate\Validator;

beforeAll(function () {
    class MyClass {
        public function __construct(#[Required] public string $name) {

        }

        #[Required]
        public string $address;

        #[Required]
        public string $description;

        public string $normalAttrib;
    }
});

describe("Required feature validation", function () {
    it('Should be valid', function () {
        $myObj = new MyClass("Test ABC");
        $myObj->address = "Some address string";
        $myObj->description = "Some desc string for testing";

        $validationResponse = Validator::validate($myObj);

        expect($validationResponse->isValid())->toBeTrue();
        expect($validationResponse->getErrors())->toBeEmpty();
    });

    it('Should return errors', function () {
        $myObj = new MyClass("");

        $validationResponse = Validator::validate($myObj);

        expect($validationResponse->isValid())->toBeFalse();
        expect($validationResponse->getErrors())->toHaveKeys(['name', 'address', 'description']);
    });
});


