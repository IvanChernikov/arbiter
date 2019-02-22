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
        var_dump($context);
        if ($context instanceof IterationContext) {
            $it = $context->iteration();
            $truth = $it === $this->expected;
            echo "{$it} " . ($truth ? '=' : '!') . "== {$this->expected}";
            return $truth;
        }
        return false;
    }

    /**
     * @return string
     */
    public function digest()
    {
        return sha1(implode([static::class, $this->expected]));
    }
}