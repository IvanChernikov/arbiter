<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Tests\Mocks\Contracts\IterationContext;
use Carbon\Carbon;

class TestContext implements IterationContext
{
    protected $timestamp;

    /**
     * TestContext constructor.
     */
    public function __construct()
    {
        $this->timestamp = Carbon::now();
    }

    /**
     * @return Carbon
     */
    public function timestamp()
    {
        return $this->timestamp;
    }

    static $iteration = 0;

    /**
     * @return int
     */
    public function iteration()
    {
        return static::$iteration++;
    }
}