<?php

namespace Arbiter\Builder;

use Arbiter\Contracts\ContextContract;
use Arbiter\Core\Rule;

class DynamicRule extends Rule
{

    protected $predicate;
    protected $dependencies;

    /**
     * DynamicRule constructor.
     * @param Predicate $predicate
     * @param Rule ...$dependencies
     */
    public function __construct(Predicate $predicate, Rule ...$dependencies)
    {
        $this->predicate    = $predicate;
        $this->dependencies = $dependencies;
    }

    /**
     * @param ContextContract $context
     * @return bool
     */
    public function evaluate(ContextContract $context)
    {
        $predicate = $this->predicate;
        return $predicate($context);
    }

    /**
     * @param ContextContract $context
     * @return Rule[]
     */
    public function expand(ContextContract $context)
    {
        return $this->dependencies;
    }

    /**
     * Returns a normalized array of parameters
     *
     * @return array
     */
    public function normalize()
    {
        return [spl_object_hash($this)];
    }
}