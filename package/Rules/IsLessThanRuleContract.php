<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\SourceRuleContract;
use Arbiter\Core\Rule;

abstract class IsLessThanRuleContract extends Rule implements SourceRuleContract
{
    protected $ceiling;

    /**
     * IsLessThan constructor.
     * @param $ceiling
     */
    public function __construct($ceiling)
    {
        $this->ceiling = $ceiling;
    }

    /**
     * Evaluates the rule
     *
     * @param ContextContract $context
     * @return bool
     */
    public function evaluate(ContextContract $context)
    {
        return $this->source($context) < $this->ceiling;
    }

    /**
     * Returns an ordered array of parameters
     *
     * @return mixed
     */
    public function normalize()
    {
        return [
            'ceiling' => $this->ceiling,
        ];
    }
}