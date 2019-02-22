<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\App\IterationContext;
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
    public function iteration()
    {
        return static::$iteration++;
    }
}