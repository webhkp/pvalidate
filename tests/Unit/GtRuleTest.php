<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\Gt;

beforeEach(function () {
    $this->rule = new Gt(100);
});

describe("Gt(Greater than) validation", function () {
    it('Should return min error', function () {
        $validationResult = $this->rule->safeParse(10);

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('min');
    });

    it('Should return return error for being equal', function () {
        $validationResult = $this->rule->safeParse(100);

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('min');
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
