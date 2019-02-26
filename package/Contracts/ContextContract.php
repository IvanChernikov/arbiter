<?php

namespace Arbiter\Contracts;

use Carbon\Carbon;

interface ContextContract
{
    /**
     * Returns the time of creation
     *
     * @return Carbon
     */
    public function timestamp();

    /**
     * Returns a JSON serializable array
     *
     * @return array
     */
    public function serialize();
}