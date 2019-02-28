<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Contracts\ContextContract;
use Carbon\Carbon;

class SimpleContext implements ContextContract
{
    private $timestamp;

    public function __construct($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * Returns the time of creation
     *
     * @return Carbon
     */
    public function timestamp()
    {
        return $this->timestamp;
    }

    /**
     * Returns a JSON serializable array
     * Enforcing array return in order to easily merge with parent
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'timestamp' => $this->timestamp
        ];
    }
}