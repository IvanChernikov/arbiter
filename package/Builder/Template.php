<?php

namespace Arbiter\Builder;

use Arbiter\Contracts\RuleContract;
use Closure;

class Template
{
    protected $predicate;
    protected $children = [];

    /**
     * Defines the evaluate predicate
     *
     * @param Closure $value
     * @return Predicate
     */
    public function predicate(Closure $value)
    {
        $this->predicate = new Predicate($value);
        return $this->predicate;
    }

    /**
     * @param RuleContract ...$rules
     */
    public function children(RuleContract ...$rules)
    {
        $this->children = $rules;
    }

    public function make()
    {
        return new DynamicRule($this->predicate, ...$this->children);
    }
}