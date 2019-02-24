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
     * @return Rule[]
     */
    public function getDependencies();

    /**
     * Returns a unique signature of the rule
     *
     * @return string
     */
    public function getDigest();

    /**
     * Returns an ordered array of parameters
     *
     * @return mixed
     */
    public function getNormalizedParameters();
}