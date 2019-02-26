<?php

namespace Arbiter\Contracts;

interface ArbiterContract
{
    /**
     * @param RuleContract $rule
     * @return ResultContract
     */
    public function evaluate(RuleContract $rule);

    /**
     * @param RuleContract $rule
     * @return RuleContract[]
     */
    public function expand(RuleContract $rule);

    /**
     * @param RuleContract $rule
     * @return ResultContract
     */
    public function refuse(RuleContract $rule);

    /**
     * @return ResultContract
     */
    public function approve();
}