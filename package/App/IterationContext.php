<?php

namespace Arbiter\App;

use Arbiter\Rules\Contracts\Context;

interface IterationContext extends Context
{
    /**
     * @return int
     */
    public function iteration();
}