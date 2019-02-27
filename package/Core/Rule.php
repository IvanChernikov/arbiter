<?php

namespace Arbiter\Core;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\RuleContract;

abstract class Rule implements RuleContract
{
    /**
     * @param ContextContract $context
     * @return Rule[]
     */
    public function expand(ContextContract $context)
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
        return sha1(implode($this->jsonSerialize()));
    }

    /**
     * @return array|mixed
     */
    final public function jsonSerialize()
    {
        return array_merge([static::class], $this->normalize());
    }
}