<?php

use Webhkp\Pvalidate\Exceptions\PvalidateException;
use Webhkp\Pvalidate\Rules\Builder\RangeRuleBuilder;

describe("Range rule builder validation", function () {
    it('Should be valid', function () {
        $rule = (new RangeRuleBuilder())->setMin(5)->setMax(10)->build();
        $validationResult = $rule->safeParse(7);

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return \'min\' error on safeParse', function () {
        $rule = (new RangeRuleBuilder())->setMin(10)->build();
        $validationResult = $rule->safeParse(5);

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('min');
    });

    it('Should return \'max\' error on safeParse', function () {
        $rule = (new RangeRuleBuilder())->setMax(10)->build();
        $validationResult = $rule->safeParse(100);

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('max');
    });

    it('Should return \'wrongParam\' error', function () {
        $rule = (new RangeRuleBuilder())->setMin(100)->setMax(5)->build();
        $validationResult = $rule->safeParse(10);

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('wrongParam');
    });

    it('Should throw exception on parse', function () {
        $rule = (new RangeRuleBuilder())->setMax(10)->build();
        $rule->parse(100);
    })->throws(PvalidateException::class);
});
