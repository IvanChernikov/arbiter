<?php

namespace Arbiter\Core;

use Arbiter\Contracts\Context;

abstract class Rule implements \Arbiter\Contracts\Rule
{
    /**
     * @param Context $context
     * @return Rule[]
     */
    public function expand(Context $context)
    {
        return [];
    }

    /**
     * Returns a unique digest
     * Parameter keys are ignored
     *
     * @return string
     */
    final public function hash()
    {
        return sha1(implode(
            array_merge([
                static::class,
            ], $this->normalize())
        ));
    }
}