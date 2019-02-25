<?php

namespace Arbiter\Builder;

use Arbiter\Contracts\Context;
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
     * @param Context $context
     * @return bool
     */
    public function evaluate(Context $context)
    {
        $predicate = $this->predicate;
        return $predicate($context);
    }

    /**
     * @param Context $context
     * @return Rule[]
     */
    public function expand(Context $context)
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