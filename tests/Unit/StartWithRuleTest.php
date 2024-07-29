<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\StartWith;

beforeEach(function () {
    $this->rule = new StartWith('quick');
    $this->ruleInsensitive = new StartWith('quick', true);
});

describe("Start with validation", function () {
    it('Should be valid', function () {
        $validationResult = $this->rule->safeParse('quick brown fox jumps over the lazy dog');

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should be valid for case insensitive comparison', function () {
        $validationResult = $this->ruleInsensitive->safeParse('QuiCK brown fox jumps over the lazy dog');

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return \'startWith\' error on safeParse', function () {
        $validationResult = $this->rule->safeParse('blah blah, quick brown fox jumps over the lazy dog');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('startWith');
    });

    it('Should return \'startWith\' error on safeParse for case insensitve comparison', function () {
        $validationResult = $this->ruleInsensitive->safeParse('blah blah, quick brown fox jumps over the lazy dog');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('startWith');
    });

    it('Should throw exception on parse', function () {
        $this->rule->parse('jumps over the lazy dog');
    })->throws(PvalidateException::class);
});
