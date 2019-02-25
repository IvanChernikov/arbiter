<?php

namespace Arbiter\Tests\Mocks;

use Arbiter\Contracts\Context;

class NestedRule extends Rule
{
    protected $rules;
    public function __construct($expected, Rule ...$rules)
    {
        parent::__construct($expected);
        $this->rules = $rules;
    }

    public function expand(Context $context)
    {
        return $this->rules;
    }
}