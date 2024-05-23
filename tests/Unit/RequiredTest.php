<?php
use Webhkp\Pvalidate\Validators\Required;

beforeEach(function() {
    $this->required = new Required();
});

describe("Required validation", function () {
    it('Should be valid', function () {
        $obj = new stdClass();
        $obj->name = "test name";

        $prop = new ReflectionProperty($obj, 'name');

        $validationResult = $this->required->validate($prop, $obj);

        expect($validationResult->isValid())->toBeTrue();
        expect($validationResult->getErrors())->toBeEmpty();
    });

    it('Should return errors', function () {
        $obj = new stdClass();
        $obj->name = "";

        $prop = new ReflectionProperty($obj, 'name');

        $validationResult = $this->required->validate($prop, $obj);

        expect($validationResult->isValid())->toBeFalse();
        expect($validationResult->getErrors())->toHaveKey('required');
    });
});
