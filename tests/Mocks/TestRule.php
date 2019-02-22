<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\App\IterationContext;
use Arbiter\Rules\Contracts\Context;
use Arbiter\Rules\Rule;

class TestRule extends Rule
{
    protected $expected;

    public function __construct($expected)
    {
        $this->expected = $expected;
    }

    /**
     * @param Context $context
     * @return bool
     */
    public function evaluate(Context $context)
    {
        if ($context instanceof IterationContext) {
            $it = $context->iteration();
            $truth = $it === $this->expected;
            echo "{$it} (iteration) " . ($truth ? '=' : '!') . "== {$this->expected}(actual)\n";
            return $truth;
        }
        return false;
    }

    /**
     * @return string
     */
    public function digest()
    {
        static $i = 0;
        return sha1(implode([static::class, $this->expected, $i++]));
    }
}