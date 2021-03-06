<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Tests\Mocks\Contracts\OrderedContextContract;
use Arbiter\Contracts\ContextContract;

class IsInOrder extends \Arbiter\Core\Rule
{
    protected $expected;

    public function __construct($expected)
    {
        $this->expected = $expected;
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
            'expected'  => $this->expected,
        ];
    }
}