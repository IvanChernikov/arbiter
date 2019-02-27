<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\SourceRuleContract;
use Arbiter\Core\Rule;

abstract class IsEqualRuleContract extends Rule implements SourceRuleContract
{
    protected $value;

    /**
     * IsEqual constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Evaluates the rule
     *
     * @param ContextContract $context
     * @return bool
     */
    public function evaluate(ContextContract $context)
    {
        return $this->source($context) == $this->value;
    }

    /**
     * Returns an ordered array of parameters
     *
     * @return mixed
     */
    public function normalize()
    {
        return [
            'value' => $this->value,
        ];
    }
}