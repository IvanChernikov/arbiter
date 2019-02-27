<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Contracts\ContextContract;
use Arbiter\Rules\IsEqualRule;

class IsTrue extends IsEqualRule
{
    /**
     * @param ContextContract $context
     * @return bool
     */
    public function getValue(ContextContract $context)
    {
        return true;
    }
}