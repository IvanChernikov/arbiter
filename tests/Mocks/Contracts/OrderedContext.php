<?php

namespace Arbiter\Tests\Mocks\Contracts;

use Arbiter\Contracts\Context;

interface OrderedContext extends Context
{
    /**
     * @return int
     */
    public function iteration();
}