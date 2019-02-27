<?php

namespace Arbiter\Contracts;

interface SourceRuleContract
{
    /**
     * Defines the source of the value to be evaluated by the implementing rule
     *
     * @param ContextContract $context
     * @return mixed
     */
    public function source(ContextContract $context);
}