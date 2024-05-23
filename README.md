# Pvalidate

Simple and flexible validator for PHP

## Installation

```bash
composer require webhkp/pvalidate
```

## Usage 

```php
<?php

require_once "vendor/autoload.php";

use Webhkp\Pvalidate\Validator;
use Webhkp\Pvalidate\Validators\Required;
use Webhkp\Pvalidate\Validators\Range;

class MyClass {
    public function __construct(
        #[Required]
        public string $name){
        
    }

    #[Required]
    public string $address;

    #[Required]
    public string $description;

    #[Range(min:50, max:60)]
    const AGE = 40;

    #[Range(min:50)]
    public int $prop1 = 40;

    #[Range(max:10)]
    public int $prop2 = 40;
    
    #[Range()]
    public int $prop3 = 40;
}


// Usage
$myObj = new MyClass("Test ABC");
$myObj->description = "Some desc string for testing";

$validationResponse = Validator::validate($myObj);

var_dump($validationResponse->isValid());
var_dump($validationResponse->getErrors());
```

## Output

```
bool(false)

array(3) {
  ["address"]=>
  array(1) {
    ["required"]=>
    string(19) "address is Required"
  }
  ["prop1"]=>
  array(1) {
    ["min"]=>
    string(42) "prop1 should be larger than or equal to 50"
  }
  ["prop2"]=>
  array(1) {
    ["max"]=>
    string(43) "prop2 should be smaller than or equal to 10"
  }
}
```
