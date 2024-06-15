<?php

use Webhkp\Pvalidate\Rules\Required;
use Webhkp\Pvalidate\Validator;

beforeEach(function () {
    $this->testObj = new class {
        public function __construct() {
        }

        #[Required] 
        public string $name;

        #[Required]
        public string $address;

        #[Required]
        public string $description;

        public string $normalAttrib;
    };
});

describe("Required feature validation", function () {
    it('Should be valid', function () {
        $this->testObj->name = "some name";
        $this->testObj->address = "Some address string";
        $this->testObj->description = "Some desc string for testing";

        $validationResponse = Validator::validate($this->testObj);

        expect($validationResponse->isValid())->toBeTrue();
        expect($validationResponse->getErrors())->toBeEmpty();
    });

    it('Should return errors', function () {
        $validationResponse = Validator::validate($this->testObj);

        expect($validationResponse->isValid())->toBeFalse();
        expect($validationResponse->getErrors())->toHaveKeys(['name', 'address', 'description']);
    });
});


