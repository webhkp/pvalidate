<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\Gte;

beforeEach(function () {
    $this->rule = new Gte(100);
});

describe("Gte(Greater than or equal) validation", function () {
    it('Should return min error', function () {
        $validationResult = $this->rule->safeParse(10);

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('min');
    });

    it('Should return success for being equal', function () {
        $validationResult = $this->rule->safeParse(100);

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should be valid', function () {
        $validationResult = $this->rule->safeParse(900);

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should throw exception on parse', function () {
        $this->rule->parse(50);
    })->throws(PvalidateException::class);
});
