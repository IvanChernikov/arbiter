<?php

namespace Arbiter\Contracts;

interface CustomValueRule
{
    /**
     * @param ContextContract $context
     * @return mixed
     */
    public function getValue(ContextContract $context);
}