<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules\Builder;

use Attribute;
use Webhkp\Pvalidate\Rules\ValidationRule;

interface RuleBuilder {
    public function build(): ValidationRule;
}