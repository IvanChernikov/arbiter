<?php

namespace Arbiter\Contracts;

use Carbon\Carbon;

interface Context
{
    /**
     * @return Carbon
     */
    public function timestamp();
}