<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\MaxLength;

beforeEach(function () {
    $this->rule = new MaxLength(10);
});

describe("MaxLength validation", function () {
    it('Should be valid', function () {
        $validationResult = $this->rule->safeParse('abc');

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return \'maxLength\' error on safeParse', function () {
        $validationResult = $this->rule->safeParse('abc def ghi jkl mno');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('maxLength');
    });

    it('Should throw exception on parse', function () {
        $this->rule->parse('abc def ghi jkl mno');
    })->throws(PvalidateException::class);
});
