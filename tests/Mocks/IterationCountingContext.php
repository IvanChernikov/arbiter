<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Tests\Mocks\Contracts\IterationContext;
use Carbon\Carbon;

class IterationCountingContext implements IterationContext
{
    protected $timestamp;
    protected $iteration;

    /**
     * TestContext constructor.
     */
    public function __construct()
    {
        $this->timestamp = Carbon::now();
        $this->iteration = 0;
    }

    /**
     * @return Carbon
     */
    public function timestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return int
     */
    public function iteration()
    {
        return $this->iteration++;
    }
}