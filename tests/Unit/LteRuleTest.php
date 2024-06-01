<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\Lte;

beforeEach(function () {
    $this->rule = new Lte(100);
});

describe("Lte(Less than or equal) validation", function () {
    it('Should return success', function () {
        $validationResult = $this->rule->safeParse(10);

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return success for being equal', function () {
        $validationResult = $this->rule->safeParse(100);

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return error for larger value', function () {
        $validationResult = $this->rule->safeParse(900);

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('max');
    });

    it('Should throw exception on parse', function () {
        $this->rule->parse(400);
    })->throws(PvalidateException::class);
});
