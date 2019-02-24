<?php

namespace Arbiter\Builder;

use Arbiter\Core\Rule;
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
     * @param Rule ...$rules
     */
    public function children(Rule ...$rules)
    {
        $this->children = $rules;
    }

    public function make()
    {
        return new DynamicRule($this->predicate, ...$this->children);
    }
}