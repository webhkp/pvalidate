<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules\Builder;

use Webhkp\Pvalidate\Rules\Range;
use Webhkp\Pvalidate\Rules\ValidationRule;

class RangeRuleBuilder implements RuleBuilder {
    private ?float $min = null;
    private ?float $max = null;

    public function setMin(float $min): static {
        $this->min = $min;
        return $this;
    }

    public function setMax(float $max): static {
        $this->max = $max;
        return $this;
    }

    public function build(): ValidationRule {
        return new Range($this->min, $this->max);
    }
}