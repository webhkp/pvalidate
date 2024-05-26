<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\Regex;

beforeEach(function () {
    $this->rule = new Regex('/^[A-Z0-9]{3}.*/');
});

describe("Regex validation", function () {
    it('Should be valid', function () {
        $validationResult = $this->rule->safeParse('CD9i87');

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });
    
    it('Should return error with safeParse', function () {
        $validationResult = $this->rule->safeParse('kd93jdkD3aeK3i');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('regex');
    });

    it('Should throw exception on parse', function () {
        $this->rule->parse('[eo34jmKh');
    })->throws(PvalidateException::class);
});

