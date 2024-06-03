<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\ValidationBuilder;

describe("Validation Builder", function () {
    describe("Builder creation", function () {
        it('should thorw Error on new instance createion', function () {
            $builderInstance = new ValidationBuilder();
        })->throws(Error::class);
    });

    describe('Static function call', function () {
        it('should return an instance of ValidationBuilder', function () {
            $validation = ValidationBuilder::required();

            expect($validation)->toBeInstanceOf(ValidationBuilder::class);
        });

        it('should return seperate instances after seperate call', function () {
            $validation1 = ValidationBuilder::required();
            $validation2 = ValidationBuilder::gt(10);

            expect($validation1)->not()->toEqual($validation2);
        });

        it('should return success on correct data parsing and safe parsing', function () {
            $validation = ValidationBuilder::required()->safeParse(100);

            expect($validation->isValid())->toBeTrue();

            $validation2 = ValidationBuilder::required()->parse(100);

            expect($validation2->isValid())->toBeTrue();
        });

        it('should return error on wrong data parsing', function () {
            $validation3 = ValidationBuilder::range(min: 20, max: 40)->safeParse(100);

            expect($validation3->isValid())->toBeFalse();
            expect($validation3->getErrors())->toHaveKey('range');
        });
    });

    describe('Normal function call', function () {
        it('should return instance of ValidationBuilder', function () {
            $validation = ValidationBuilder::required()->range();

            expect($validation)->toBeInstanceOf(ValidationBuilder::class);

            $validation = $validation->required();

            expect($validation)->toBeInstanceOf(ValidationBuilder::class);

            $validation = $validation->gt(100)->gte(100);

            expect($validation)->toBeInstanceOf(ValidationBuilder::class);

            $validation = $validation->lt(100)->lte(100)->allow([2, 3, 4, 5]);

            expect($validation)->toBeInstanceOf(ValidationBuilder::class);
        });

    });

    describe('Safe Parsing', function () {
        it('should parse safely and return success result', function () {
            $validation3 = ValidationBuilder::range(min: 20, max: 40)->safeParse(30);

            expect($validation3->isValid())->toBeTrue();
            expect($validation3->getErrors())->toBeEmpty();
        });

        it('should parse safely and return errors', function () {
            $validation3 = ValidationBuilder::range(min: 20, max: 40)->allow([1, 2, 3, 4, 5])->safeParse(100);

            expect($validation3->isValid())->toBeFalse();
            expect($validation3->getErrors())->toHaveKey('range');
            expect($validation3->getErrors())->toHaveKey('allow');
        });
    });

    describe('Normal Parsing', function () {
        it('should parse and return success', function () {
            $validation3 = ValidationBuilder::range(min: 20, max: 40)->parse(30);

            expect($validation3->isValid())->toBeTrue();
            expect($validation3->getErrors())->toBeEmpty();
        });

        it('should parse and throw exception', function () {
            $validation3 = ValidationBuilder::range(min: 20, max: 40)->parse(100);
        })->throws(PvalidateException::class);
    });
});
