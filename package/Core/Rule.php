<?php

namespace Arbiter\Core;

abstract class Rule implements \Arbiter\Contracts\Rule
{
    /**
     * @return Rule[]
     */
    public function getDependencies()
    {
        return [];
    }

    /**
     * Returns a unique digest
     * Parameter keys are ignored
     *
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
     * Returns a normalized array of parameters
     *
     * @return array
     */
    abstract public function getNormalizedParameters();
}