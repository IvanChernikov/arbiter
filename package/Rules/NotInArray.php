<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\Context;

abstract class NotInArray extends InArray
{
    /**
     * @param Context $context
     * @return bool
     */
    public function evaluate(Context $context)
    {
        return !parent::evaluate($context);
    }
}