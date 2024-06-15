<?php

declare(strict_types=1);

namespace Webhkp\Pvalidate\Rules\Builder;

use Attribute;
use Webhkp\Pvalidate\Rules\Length;
use Webhkp\Pvalidate\Rules\ValidationRule;

#[Attribute]
class LengthRuleBuilder implements RuleBuilder {
    private $minLength;
    private $maxLength;

    public function setMinLength(int $minLength): static {
        $this->minLength = $minLength;
        return $this;
    }

    public function setMaxLength(int $maxLength): static {
        $this->maxLength = $maxLength;
        return $this;
    }

    public function build(): ValidationRule {
        return new Length($this->minLength, $this->maxLength);
    }
}