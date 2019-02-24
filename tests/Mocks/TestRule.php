<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Tests\Mocks\Contracts\IterationContext;
use Arbiter\Contracts\Context;
use Arbiter\Core\Rule;

class TestRule extends Rule
{
    protected $expected;
    protected $iteration;

    public function __construct($expected)
    {
        static $i = 0;
        $this->expected = $expected;
        $this->iteration = $i++;
    }

    /**
     * @param Context $context
     * @return bool
     */
    public function evaluate(Context $context)
    {
        if ($context instanceof IterationContext) {
            return $context->iteration() === $this->expected;
        }
        return false;
    }

    /**
     * @return array;
     */
    public function getNormalizedParameters()
    {
        return [
            'expected' => $this->expected,
            'iteration' => $this->iteration,
        ];
    }
}