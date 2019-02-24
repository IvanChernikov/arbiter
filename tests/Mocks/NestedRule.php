<?php

namespace Arbiter\Tests\Mocks;

class NestedRule extends TestRule
{
    protected $rules;
    public function __construct($expected, TestRule ...$rules)
    {
        parent::__construct($expected);
        $this->rules = $rules;
    }

    public function getDependencies()
    {
        return $this->rules;
    }

}