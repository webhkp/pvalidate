<?php

use Webhkp\Pvalidate\Rules\Length;
use Webhkp\Pvalidate\ValidationBuilder;
use Webhkp\Pvalidate\Validator;

beforeEach(function () {
    $this->testObj = new class {
        public function __construct() {
        }

        #[Length(2, 5)]
        public string $firstString = 'my first string';

        #[Length(min: 20)]
        public string $secondString = 'my second string';

        #[Length(max: 10)]
        public string $thirdString = 'my third string';

        #[Length(min: 20, max: 50)]
        public string $fourthString = 'my fourth string';
    };
});

describe("Length Validation", function () {
    describe("Object attribute validation", function () {
        it('Should be valid', function () {
            $this->testObj->firstString = "abc";
            $this->testObj->secondString = "abc def ghi jkl mno pqr stu vwx yz";
            $this->testObj->thirdString = "abc def";
            $this->testObj->fourthString = "abc def ghi jkl mno pqr stu vwx yz";

            $validationResponse = Validator::validate($this->testObj);

            expect($validationResponse->isValid())->toBeTrue();
            expect($validationResponse->getErrors())->toBeEmpty();
        });

        it('Should return errors', function () {
            $validationResponse = Validator::validate($this->testObj);

            expect($validationResponse->isValid())->toBeFalse();
            expect($validationResponse->getErrors())->toHaveKeys(['firstString', 'secondString', 'thirdString', 'fourthString']);
        });
    });

    describe("Validation builder parsing", function () {
        it('Should return error for string longer than the max length', function () {
            $validation = ValidationBuilder::length(10, 20)->safeParse('abc def ghi jkl mno pqr stu vwx yz');

            expect($validation->isValid())->toBeFalse();
            expect($validation->getErrors())->toHaveKeys(['length.errors.maxLength']);
        });
    });
});


