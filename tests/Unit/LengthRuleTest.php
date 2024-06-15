<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\Length;

beforeEach(function () {
    $this->rule = new Length(min: 5, max: 10);
});

describe("Length validation", function () {
    it('Should be valid', function () {
        $validationResult = $this->rule->safeParse('abcdef');

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return \'minLength\' error on safeParse', function () {
        $validationResult = $this->rule->safeParse('abc');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('minLength');
    });
    
    it('Should return \'maxLength\' error on safeParse', function () {
        $validationResult = $this->rule->safeParse('abc def ghi jkl mno');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('maxLength');
    });

    it('Should return \'wrongParam\' error', function() {
        $validationResult = (new Length(100, 5))->safeParse('some string here');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('wrongParam');
    });

    it('Should throw exception on parse', function () {
        $this->rule->parse('abc def ghi jkl mno');
    })->throws(PvalidateException::class);
});
