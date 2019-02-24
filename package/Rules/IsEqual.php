<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\Context;
use Arbiter\Contracts\CustomValueRule;
use Arbiter\Core\Rule;

abstract class IsEqual extends Rule implements CustomValueRule
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Evaluates the rule
     *
     * @param Context $context
     * @return bool
     */
    public function evaluate(Context $context)
    {
        return $this->getValue($context) == $this->value;
    }

    /**
     * Returns an ordered array of parameters
     *
     * @return mixed
     */
    public function getNormalizedParameters()
    {
        return [
            'value' => $this->value,
        ];
    }
}