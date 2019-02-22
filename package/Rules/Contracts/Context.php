<?php

namespace Arbiter\Rules\Contracts;

use Carbon\Carbon;

interface Context
{
    /**
     * @return Carbon
     */
    public function timestamp();

    /**
     * @return Arbiter
     */
    public function arbiter();
}