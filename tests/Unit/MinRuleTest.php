<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\MinLength;

beforeEach(function () {
    $this->rule = new MinLength(10);
});

describe("MinLength validation", function () {
    it('Should be valid', function () {
        $validationResult = $this->rule->safeParse('abc def ghi jkl mno');

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return \'minLength\' error on safeParse', function () {
        $validationResult = $this->rule->safeParse('abc');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('minLength');
    });

    it('Should throw exception on parse', function () {
        $this->rule->parse('abc');
    })->throws(PvalidateException::class);
});
