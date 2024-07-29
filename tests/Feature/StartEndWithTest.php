<?php

use Webhkp\Pvalidate\Rules\EndWith;
use Webhkp\Pvalidate\Rules\StartWith;
use Webhkp\Pvalidate\ValidationBuilder;
use Webhkp\Pvalidate\Validator;

beforeEach(function () {
    $this->testObj = new class {
        public function __construct(
        ) {
    
        }
    
        #[StartWith('my')]
        public string $firstString = 'my first string';    
        
        #[StartWith('my')]
        public string $secondString = 'My second string';    
        
        #[StartWith('MY', true)]
        public string $thirdString = 'My third string';    
        
        #[EndWith('string')]
        public string $fourthString = 'my fourth string';    
        
        #[EndWith('STRING')]
        public string $fifthString = 'My fifth StrinG';    
        
        #[EndWith('string', true)]
        public string $sixthString = 'My sixth String';    
    
        #[StartWith('MY')]
        #[EndWith('string')]
        public string $seventhString = 'My seventh String';    
    
        #[StartWith('MY', true)]
        #[EndWith('STRING', true)]
        public string $eighthString = 'My eighth String';    
    };
});

describe("Start with Validation", function () {
    describe("Object attribute validation", function () {
        it('Should be valid', function () {
            $this->testObj->firstString = "my test string";
            $this->testObj->secondString = "my test string";
            $this->testObj->thirdString = "MY TEST string";
            $this->testObj->fourthString = "my test string";
            $this->testObj->fifthString = "my test STRING";
            $this->testObj->sixthString = "my test STRING";
            $this->testObj->seventhString = "MY test string";
            $this->testObj->eighthString = "my test STRING";

            $validationResponse = Validator::validate($this->testObj);

            expect($validationResponse->isValid())->toBeTrue();
            expect($validationResponse->getErrors())->toBeEmpty();
        });

        it('Should return errors', function () {
            $validationResponse = Validator::validate($this->testObj);

            expect($validationResponse->isValid())->toBeFalse();
            expect($validationResponse->getErrors())->toHaveKeys(['secondString', 'fifthString', 'seventhString']);
        });
    });

    describe("Validation builder parsing", function () {
        it('Should return error for startwith violation', function () {
            $validation = ValidationBuilder::startWith("wrong wrong")->safeParse('quick brown fox jumps over the lazy dog');

            expect($validation->isValid())->toBeFalse();
            expect($validation->getErrors())->toHaveKeys(['startWith.errors.startWith']);
        });

        it('Should return error for endWtith violation', function () {
            $validation = ValidationBuilder::endWith('wrong')->safeParse('quick brown fox jumps over the lazy dog');

            expect($validation->isValid())->toBeFalse();
            expect($validation->getErrors())->toHaveKeys(['endWith.errors.endWith']);
        });

        it('Should return error for both startWith and endWith violation', function () {
            $validation = ValidationBuilder::startWith("wrong")->endWith('Something else');

            $validationResult = $validation->safeParse('abc');

            expect($validationResult->isValid())->toBeFalse();
            expect($validationResult->getErrors())->toHaveKeys(['startWith.errors.startWith', 'endWith.errors.endWith']);
        });
    });
});


