<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\Context;
use Arbiter\Contracts\CustomValueRule;
use Arbiter\Core\Rule;

abstract class IsGreaterThan extends Rule implements CustomValueRule
{
    protected $floor;

    /**
     * IsGreaterThan constructor.
     * @param $floor
     */
    public function __construct($floor)
    {
        $this->floor = $floor;
    }

    /**
     * Evaluates the rule
     *
     * @param Context $context
     * @return bool
     */
    public function evaluate(Context $context)
    {
        return $this->getValue($context) > $this->floor;
    }

    /**
     * Returns an ordered array of parameters
     *
     * @return mixed
     */
    public function getNormalizedParameters()
    {
        return [
            'floor' => $this->floor,
        ];
    }
}