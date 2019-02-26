<?php

namespace Arbiter\Tests\Mocks\Contracts;

use Arbiter\Contracts\ContextContract;

interface OrderedContextContract extends ContextContract
{
    /**
     * @return int
     */
    public function iteration();
}