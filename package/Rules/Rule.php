<?php

namespace Arbiter\Rules;

use Arbiter\Rules\Contracts\Context;

abstract class Rule
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
    final public function getDigest()
    {
        return sha1(implode(
            array_merge([
                static::class,
            ], $this->getNormalizedParameters())
        ));
    }

    /**
     * @return array;
     */
    abstract public function getNormalizedParameters();
}