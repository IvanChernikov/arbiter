<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Tests\Mocks\Contracts\IterationContext;
use Arbiter\Contracts\Context;

class Rule extends \Arbiter\Core\Rule
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
        echo sprintf('%10s === %-10s', 'expected ' . $this->expected, 'actual ' . $this->iteration) . PHP_EOL;
        if ($context instanceof IterationContext) {
            return $context->iteration() === $this->expected;
        }
        return false;
    }

    /**
     * @return array;
     */
    public function normalize()
    {
        return [
            'expected' => $this->expected,
            'iteration' => $this->iteration,
        ];
    }
}