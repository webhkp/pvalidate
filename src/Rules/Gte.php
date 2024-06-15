<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Gte extends Range {
    public function __construct(
        readonly private float $compareWith
    ) {
        parent::__construct(min: $compareWith);
    }
}