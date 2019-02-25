<?php

namespace Arbiter\Contracts;

interface Rule
{
    /**
     * Evaluates the rule
     *
     * @param Context $context
     * @return bool
     */
    public function evaluate(Context $context);

    /**
     * Returns an array of rules that should be evaluated prior
     *
     * @param Context $context
     * @return Rule[]
     */
    public function expand(Context $context);

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