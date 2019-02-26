<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\CustomValueRule;
use Arbiter\Core\Rule;

abstract class IsEqualRule extends Rule implements CustomValueRule
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
        return $this->getValue($context) == $this->value;
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