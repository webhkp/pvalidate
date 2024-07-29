<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\EndWith;

beforeEach(function () {
    $this->rule = new EndWith('dog');
    $this->ruleInsensitive = new EndWith('dog', true);
});

describe("End with validation", function () {
    it('Should be valid', function () {
        $validationResult = $this->rule->safeParse('quick brown fox jumps over the lazy dog');

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should be valid for case insensitive comparison', function () {
        $validationResult = $this->ruleInsensitive->safeParse('quick brown fox jumps over the lazy Dog');

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return \'endWith\' error on safeParse', function () {
        $validationResult = $this->rule->safeParse('quick brown fox jumps over the lazy dog, blah blah');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('endWith');
    });

    it('Should return \'endWith\' error on safeParse for case insensitve comparison', function () {
        $validationResult = $this->ruleInsensitive->safeParse('quick brown fox jumps over the lazy dog, , blah blah');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('endWith');
    });

    it('Should throw exception on parse', function () {
        $this->rule->parse('jumps over');
    })->throws(PvalidateException::class);
});
