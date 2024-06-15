<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\Builder\LengthRuleBuilder;

describe("Length rule builder validation", function () {
    it('Should be valid', function () {
        $rule = (new LengthRuleBuilder())->setMinLength(5)->setMaxLength(10)->build();
        $validationResult = $rule->safeParse('abcdef');

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return \'minLength\' error on safeParse', function () {
        $rule = (new LengthRuleBuilder())->setMinLength(10)->build();
        $validationResult = $rule->safeParse('abc');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('minLength');
    });

    it('Should return \'maxLength\' error on safeParse', function () {
        $rule = (new LengthRuleBuilder())->setMaxLength(10)->build();
        $validationResult = $rule->safeParse('abc def ghi jkl mno');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('maxLength');
    });

    it('Should return \'wrongParam\' error', function () {
        $rule = (new LengthRuleBuilder())->setMinLength(100)->setMaxLength(5)->build();
        $validationResult = $rule->safeParse('some string here');

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('wrongParam');
    });

    it('Should throw exception on parse', function () {
        $rule = (new LengthRuleBuilder())->setMaxLength(10)->build();
        $rule->parse('abc def ghi jkl mno');
    })->throws(PvalidateException::class);
});
