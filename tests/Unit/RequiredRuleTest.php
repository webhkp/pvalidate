<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\Required;

beforeEach(function () {
    $this->rule = new Required();
});

describe("Required validation", function () {
    it('Should be valid', function () {
        $validationResult = $this->rule->safeParse('test string here');

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return errors', function () {
        $validationResult = $this->rule->safeParse('');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('required');
    });

    it('Should throw exception', function () {
        $this->rule->parse(null);
    })->throws(PvalidateException::class);
});
