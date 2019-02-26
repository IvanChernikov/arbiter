<?php

namespace Arbiter\Contracts;

interface CustomValueRule
{
    /**
     * @param ContextContract $context
     */
    public function getValue(ContextContract $context);
}