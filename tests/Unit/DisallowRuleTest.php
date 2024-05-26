<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\Disallow;

beforeEach(function () {
    $this->rule = new Disallow([1,2,3,4,5,10]);
});

describe("Disallow validation", function () {
    it('Should be valid', function () {
        $validationResult = $this->rule->safeParse(99);

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return errors on safeParse', function () {
        $validationResult = $this->rule->safeParse(2);

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('disallowed');
    });

    it('Should handle other data types', function () {
        $validationResult = $this->rule->safeParse('abcd');

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should throw exception on parse', function () {
        $this->rule->parse(5);
    })->throws(PvalidateException::class);
});
