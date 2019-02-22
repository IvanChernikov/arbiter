<?php

namespace Arbiter\Rules;

use Arbiter\Rules\Contracts\Context;
use Arbiter\Rules\Contracts\Evaluable;

abstract class Rule implements Evaluable
{
    /**
     * @param Context $context
     * @return bool
     */
    abstract public function evaluate(Context $context);

    /**
     * @return Rule[]
     */
    public function getDependencies()
    {
        return [];
    }

    /**
     * @return string
     */
    abstract public function getDigest();
}