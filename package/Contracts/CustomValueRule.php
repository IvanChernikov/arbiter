<?php

namespace Arbiter\Contracts;

interface CustomValueRule
{
    /**
     * @param Context $context
     */
    public function getValue(Context $context);
}