<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;

#[Attribute]
class Lte extends Range {
    public function __construct(
        readonly private float $compareWith
    ) {
        parent::__construct(max: $compareWith);
    }
}