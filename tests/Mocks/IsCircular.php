<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Contracts\ContextContract;
use Arbiter\Core\Rule;

class IsCircular extends Rule
{
    /**
     * Evaluates the rule
     *
     * @param ContextContract $context
     * @return bool
     */
    public function evaluate(ContextContract $context)
    {
        return true;
    }

    /**
     * @param ContextContract $context
     * @return Rule[]|array
     */
    public function expand(ContextContract $context)
    {
        return [
            new static()
        ];
    }

    /**
     * Returns an ordered array of parameters
     *
     * @return array
     */
    public function normalize()
    {
        return [];
    }
}