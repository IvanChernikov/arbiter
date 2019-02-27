<?php

namespace Arbiter\Contracts;

use JsonSerializable;

interface RuleContract extends JsonSerializable
{
    /**
     * Evaluates the rule
     *
     * @param ContextContract $context
     * @return bool
     */
    public function evaluate(ContextContract $context);

    /**
     * Returns an array of rules that should be evaluated prior
     *
     * @param ContextContract $context
     * @return RuleContract[]
     */
    public function expand(ContextContract $context);

    /**
     * Returns a unique signature of the rule
     *
     * @return string
     */
    public function hash();

    /**
     * Returns an ordered array of parameters
     *
     * @return array
     */
    public function normalize();
}