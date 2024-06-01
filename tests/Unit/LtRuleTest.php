<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\Lt;

beforeEach(function () {
    $this->rule = new Lt(100);
});

describe("Lt(Less than) validation", function () {
    it('Should return success', function () {
        $validationResult = $this->rule->safeParse(10);

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return error for being equal', function () {
        $validationResult = $this->rule->safeParse(100);

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('max');
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
