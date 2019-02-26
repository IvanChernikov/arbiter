<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Contracts\ContextContract;

class IsInNestedOrder extends IsInOrder
{
    protected $rules;
    public function __construct($expected, IsInOrder ...$rules)
    {
        parent::__construct($expected);
        $this->rules = $rules;
    }

    public function expand(ContextContract $context)
    {
        return $this->rules;
    }
}