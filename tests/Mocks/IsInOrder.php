<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Tests\Mocks\Contracts\OrderedContextContract;
use Arbiter\Contracts\ContextContract;

class IsInOrder extends \Arbiter\Core\Rule
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
     * @param ContextContract $context
     * @return bool
     */
    public function evaluate(ContextContract $context)
    {
        if ($context instanceof OrderedContextContract) {
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