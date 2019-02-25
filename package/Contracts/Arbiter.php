<?php

namespace Arbiter\Contracts;

interface Arbiter
{
    /**
     * @param Rule $rule
     * @return Result
     */
    public function evaluate(Rule $rule);

    /**
     * @param Rule $rule
     * @return Rule[]
     */
    public function expand(Rule $rule);
}