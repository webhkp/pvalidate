<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;

#[Attribute]
class Gt extends Range {
    public function __construct(
        readonly private float $compareWith
    ) {
        parent::__construct(min: $compareWith, notEqual: true);
    }
}