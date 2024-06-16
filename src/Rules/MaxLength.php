<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class MaxLength extends Length {
    public function __construct(
        readonly private float $length
    ) {
        parent::__construct(max: $length);
    }
}