<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\Range;

beforeEach(function () {
    $this->rule = new Range(min: 100, max: 1_000);
});

describe("Range validation", function () {
    it('Should be valid', function () {
        $validationResult = $this->rule->safeParse(200);

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return \'min\' error on safeParse', function () {
        $validationResult = $this->rule->safeParse(20);

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('min');
    });
    
    it('Should return \'max\' error on safeParse', function () {
        $validationResult = $this->rule->safeParse(20_000);

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('max');
    });

    it('Should throw exception on parse', function () {
        $this->rule->parse(50,000);
    })->throws(PvalidateException::class);
});
