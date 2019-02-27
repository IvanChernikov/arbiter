<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\RuleContract;

class IsInNestedOrder extends IsInOrder
{
    protected $rules;

    /**
     * IsInNestedOrder constructor.
     * @param $expected
     * @param RuleContract ...$rules
     */
    public function __construct($expected, RuleContract ...$rules)
    {
        parent::__construct($expected);
        $this->rules = $rules;
    }

    /**
     * @param ContextContract $context
     * @return RuleContract[]|\Arbiter\Core\Rule[]
     */
    public function expand(ContextContract $context)
    {
        return $this->rules;
    }
}