# Pvalidate

![Pvalidate](https://webhkp.com/wp-content/uploads/2024/05/Pvalidate-e1716833570347.png)

Pvalidate is a robust and flexible validation library for PHP. It is designed to simplify the process of validating data, ensuring data integrity, and enforcing business rules within your PHP applications.

Whether you are building a small application or a large enterprise system, Pvalidate provides the tools you need to validate your data effectively and efficiently.

### [Check the full documentation here](https://webhkp.com/pvalidate)

## Installation

```bash
composer require webhkp/pvalidate
```

## Usage 

```php
<?php

require_once "vendor/autoload.php";


use Webhkp\Pvalidate\Rules\Regex;
use Webhkp\Pvalidate\Rules\ValidationRule;
use Webhkp\Pvalidate\Validator;
use Webhkp\Pvalidate\Rules\Required;
use Webhkp\Pvalidate\Rules\Range;
use Webhkp\Pvalidate\Rules\Allow;
use Webhkp\Pvalidate\Rules\Disallow;


class MyClass {
    public function __construct(
        #[Required]
        public string $name
    ) {

    }

    #[Required]
    public string $address;

    #[Required]
    public string $description;

    #[Range(min: 50, max: 60)]
    const AGE = 40;

    #[Range(min: 50)]
    public int $prop1 = 40;

    #[Range(max: 10)]
    #[Disallow([1, 2, 3, 40])]
    public int $prop2 = 40;

    #[Range()]
    #[Allow([1, 2, 3, 40])]
    public int $prop3 = 40;

    #[Required]
    public array $myArr = [];

    #[Regex('/[A-Z0-9]+/')]
    public string $regexTestField = 'AB23DE';
}


// Usage
$myObj = new MyClass("Test ABC");
$myObj->description = "Some desc string for testing";

$validationResponse = Validator::validate($myObj);

var_dump($validationResponse->isValid());
var_dump($validationResponse->getErrors());
//var_dump($validationResponse->getResult());

var_dump($validationResponse->getMessages());
```

## Output

```
bool(false)


array(5) {
  ["address"]=>
  array(3) {
    ["value"]=>
    NULL
    ["valid"]=>
    bool(false)
    ["errors"]=>
    array(1) {
      ["required"]=>
      string(25) "address field is Required"
    }
  }
  ["prop1"]=>
  array(3) {
    ["value"]=>
    int(40)
    ["valid"]=>
    bool(false)
    ["errors"]=>
    array(1) {
      ["min"]=>
      string(42) "prop1 should be larger than or equal to 50"
    }
  }
  ["prop2"]=>
  array(3) {
    ["value"]=>
    int(40)
    ["valid"]=>
    bool(false)
    ["errors"]=>
    array(1) {
      ["disallowed"]=>
      string(53) "prop2 should not be in the disallowed list (1,2,3,40)"
    }
  }
  ["myArr"]=>
  array(3) {
    ["value"]=>
    array(0) {
    }
    ["valid"]=>
    bool(false)
    ["errors"]=>
    array(1) {
      ["required"]=>
      string(23) "myArr field is Required"
    }
  }
}

array(5) {
  [0]=>
  string(25) "address field is Required"
  [1]=>
  string(42) "prop1 should be larger than or equal to 50"
  [2]=>
  string(53) "prop2 should not be in the disallowed list (1,2,3,40)"
  [3]=>
  string(23) "myArr field is Required"
}
```

## Individual Rule Usage

### Use "Allow" Rule

```php
<?php

require_once "vendor/autoload.php";

use Webhkp\Pvalidate\Rules\Allow;

// Check single data with rule only
$validation = new Allow([1, 2, 3, 4, 5, 10]);
$validationResult = $validation->safeParse(22);

var_dump($validationResult->isValid());
var_dump($validationResult->getErrors());
```

Output:

```
bool(false)


array(1) {
  ["allowed"]=>
  string(45) " should be in the allowed list (1,2,3,4,5,10)"
}
```

### Use 'Regex' Rule

```php
<?php

require_once "vendor/autoload.php";

use Webhkp\Pvalidate\Rules\Regex;

// Regex validation
$regexRule = new Regex('/^[A-Z0-9]{3}.*/');
$regexResult = $regexRule->safeParse('D2ab');
var_dump($regexResult->isValid());
var_dump($regexResult->getErrors());

```

Output:

```
bool(false)

array(1) {
  ["regex"]=>
  string(42) " should match the regex '/^[A-Z0-9]{3}.*/'"
}
```

## Parse and Throw Error

```php
<?php

require_once "vendor/autoload.php";

use Webhkp\Pvalidate\Rules\Required;

// Check required and throw error
try {
    $requiredValidationResult = (new Required)->parse(null);

    var_dump($requiredValidationResult->isValid());
    var_dump($requiredValidationResult->getErrors());
} catch (\Exception $e) {
    var_dump($e->getMessage());
}

```

Output:

```
object(Webhkp\Pvalidate\Exceptions\PvalidateException)#8 (8) {
  ["message":protected]=>
  string(18) " field is Required"
  ["string":"Exception":private]=>
  string(0) ""
  ["code":protected]=>
  int(1)
  ["file":protected]=>
  string(80) "package/pvalidate/src/Rules/ValidationRule.php"
  ["line":protected]=>
  int(72)
  ["trace":"Exception":private]=>
  array(1) {
    [0]=>
    array(5) {
      ["file"]=>
      string(43) "index.php"
      ["line"]=>
      int(126)
      ["function"]=>
      string(5) "parse"
      ["class"]=>
      string(37) "Webhkp\Pvalidate\Rules\ValidationRule"
      ["type"]=>
      string(2) "->"
    }
  }
  ["previous":"Exception":private]=>
  NULL
  ["additionalData":"Webhkp\Pvalidate\Exceptions\PvalidateException":private]=>
  NULL
}
```


## Custom Rule

```php
<?php

require_once "vendor/autoload.php";

use Webhkp\Pvalidate\Rules\Custom;
use Webhkp\Pvalidate\Rules\Regex;
use Webhkp\Pvalidate\Rules\ValidationRule;
use Webhkp\Pvalidate\Validator;
use Webhkp\Pvalidate\Rules\Required;
use Webhkp\Pvalidate\Rules\Range;
use Webhkp\Pvalidate\Rules\Allow;
use Webhkp\Pvalidate\Rules\Disallow;


// Define your own rule attribute
#[Attribute]
class MyCustomPasswordRule extends ValidationRule {
    public function __construct(private readonly string $minLength) {

    }

    public function isValid(): bool {
        if (strlen($this->value) >= $this->minLength) {
            return false;
        }

        // Must contain one Upper case letter
        if (!preg_match('/[A-Z]/', $this->value)) {
            return false;
        }

        // Must contain a digit
        if (!preg_match('/[0-9]/', $this->value)) {
            return false;
        }

        // Must contain a special character
        if (!preg_match('/[!@#$%^&*]$/', $this->value)) {
            return false;
        }

        return true;
    }

    public function getErrors(): array {
        $errors = [];

        if (!$this->isValid()) {
            $errors['password'] = $this->name . ' is not a valid password (minimum length ' . $this->minLength . ', must contain a uppercase letter, a digit and a special character from "!@#$%^&*")';
        }

        return $errors;
    }

}

class MyClass {
    public function __construct() {

    }

    #[Required]
    public array $myArr = [];

    #[Regex('/[A-Z0-9]+/')]
    public string $regexTestField = 'AB23DE';

    #[MyCustomPasswordRule(100)]
    public string $password = 'mysimplepass';
}


// Usage
$myObj = new MyClass();

$validationResponse = Validator::validate($myObj);

var_dump($validationResponse->isValid());
var_dump($validationResponse->getErrors());
var_dump($validationResponse->getResult());

var_dump($validationResponse->getMessages());
```

Output:

```
bool(false)

array(2) {
  ["myArr"]=>
  array(3) {
    ["value"]=>
    array(0) {
    }
    ["valid"]=>
    bool(false)
    ["errors"]=>
    array(1) {
      ["required"]=>
      string(23) "myArr field is Required"
    }
  }
  ["password"]=>
  array(3) {
    ["value"]=>
    string(12) "mysimplepass"
    ["valid"]=>
    bool(false)
    ["errors"]=>
    array(1) {
      ["password"]=>
      string(135) "password is not a valid password (minimum length 100, must contain a uppercase letter, a digit and a special character from "!@#$%^&*")"
    }
  }
}
```
