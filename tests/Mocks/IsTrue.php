<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Contracts\ContextContract;
use Arbiter\Rules\IsEqualRuleContract;

class IsTrue extends IsEqualRuleContract
{
    /**
     * @param ContextContract $context
     * @return bool
     */
    public function source(ContextContract $context)
    {
        return true;
    }
}