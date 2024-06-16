<?php

use Webhkp\Pvalidate\Rules\Length;
use Webhkp\Pvalidate\Rules\MaxLength;
use Webhkp\Pvalidate\Rules\MinLength;
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

        #[MinLength(20)]
        public string $minLengthTestString = 'abc';

        #[MaxLength(10)]
        public string $maxLengthTestString = 'abc def ghi jkl mno';
    };
});

describe("Length Validation", function () {
    describe("Object attribute validation", function () {
        it('Should be valid', function () {
            $this->testObj->firstString = "abc";
            $this->testObj->secondString = "abc def ghi jkl mno pqr stu vwx yz";
            $this->testObj->thirdString = "abc def";
            $this->testObj->fourthString = "abc def ghi jkl mno pqr stu vwx yz";
            $this->testObj->minLengthTestString = "abc def ghi jkl mno pqr stu vwx yz";
            $this->testObj->maxLengthTestString = "abc def";

            $validationResponse = Validator::validate($this->testObj);

            expect($validationResponse->isValid())->toBeTrue();
            expect($validationResponse->getErrors())->toBeEmpty();
        });

        it('Should return errors', function () {
            $validationResponse = Validator::validate($this->testObj);

            expect($validationResponse->isValid())->toBeFalse();
            expect($validationResponse->getErrors())->toHaveKeys(['firstString', 'secondString', 'thirdString', 'fourthString', 'minLengthTestString', 'maxLengthTestString']);
        });
    });

    describe("Validation builder parsing", function () {
        it('Should return error for string longer than the max length', function () {
            $validation = ValidationBuilder::length(10, 20)->safeParse('abc def ghi jkl mno pqr stu vwx yz');

            expect($validation->isValid())->toBeFalse();
            expect($validation->getErrors())->toHaveKeys(['length.errors.maxLength']);
        });

        it('Should return error for minLength violation', function () {
            $validation = ValidationBuilder::minLength(20)->safeParse('abc def');

            expect($validation->isValid())->toBeFalse();
            expect($validation->getErrors())->toHaveKeys(['minLength.errors.minLength']);
        });

        it('Should return error for maxLength violation', function () {
            $validation = ValidationBuilder::maxLength(20)->safeParse('abc def ghi jkl mno pqr stu vwx yz');

            expect($validation->isValid())->toBeFalse();
            expect($validation->getErrors())->toHaveKeys(['maxLength.errors.maxLength']);
        });

        it('Should return error for length(min or max) violation', function () {
            $validation = ValidationBuilder::minLength(10)->maxLength(20);

            $validationResult = $validation->safeParse('abc');

            expect($validationResult->isValid())->toBeFalse();
            expect($validationResult->getErrors())->toHaveKeys(['minLength.errors.minLength']);

            $validationResult = $validation->safeParse('abc def ghi jkl mno pqr stu vwx yz');

            expect($validationResult->isValid())->toBeFalse();
            expect($validationResult->getErrors())->toHaveKeys(['maxLength.errors.maxLength']);
        });
    });
});


