<?php

namespace Arbiter\Contracts;

use Carbon\Carbon;
use JsonSerializable;

interface ContextContract extends JsonSerializable
{
    /**
     * Returns the time of creation
     *
     * @return Carbon
     */
    public function timestamp();

    /**
     * Returns a JSON serializable array
     * Enforcing array return in order to easily merge with parent
     *
     * @return array
     */
    public function jsonSerialize();
}