<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\CustomValueRule;
use Arbiter\Core\Rule;

abstract class IsLessThanRule extends Rule implements CustomValueRule
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
        return $this->getValue($context) < $this->ceiling;
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