<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\Allow;

beforeEach(function () {
    $this->rule = new Allow([1,2,3,4,5,10]);
});

describe("Allow validation", function () {
    it('Should be valid', function () {
        $validationResult = $this->rule->safeParse(5);

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return errors on safeParse', function () {
        $validationResult = $this->rule->safeParse(100);

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('allowed');
    });

    it('Should handle other data types', function () {
        $validationResult = $this->rule->safeParse('abcd');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('allowed');
    });

    it('Should throw exception on parse', function () {
        $this->rule->parse(55);
    })->throws(PvalidateException::class);
});
