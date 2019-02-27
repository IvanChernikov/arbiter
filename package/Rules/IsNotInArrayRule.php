<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\ContextContract;

abstract class IsNotInArrayRule extends IsInArrayRuleContract
{
    /**
     * @param ContextContract $context
     * @return bool
     */
    public function evaluate(ContextContract $context)
    {
        return !parent::evaluate($context);
    }
}