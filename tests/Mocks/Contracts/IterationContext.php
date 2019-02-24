<?php

namespace Arbiter\Tests\Mocks\Contracts;

use Arbiter\Contracts\Context;

interface IterationContext extends Context
{
    /**
     * @return int
     */
    public function iteration();
}