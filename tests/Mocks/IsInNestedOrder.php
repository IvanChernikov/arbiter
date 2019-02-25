<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Contracts\Context;

class IsInNestedOrder extends IsInOrder
{
    protected $rules;
    public function __construct($expected, IsInOrder ...$rules)
    {
        parent::__construct($expected);
        $this->rules = $rules;
    }

    public function expand(Context $context)
    {
        return $this->rules;
    }
}