<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\Context;
use Arbiter\Contracts\CustomValueRule;
use Arbiter\Core\Rule;

abstract class IsLessThan extends Rule implements CustomValueRule
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
     * @param Context $context
     * @return bool
     */
    public function evaluate(Context $context)
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