<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\App\IterationContext;
use Arbiter\Rules\Contracts\Context;
use Arbiter\Rules\Rule;

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
            $this->expected,
            $this->iteration,
        ];
    }
}