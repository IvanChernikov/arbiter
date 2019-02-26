<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\CustomValueRule;
use Arbiter\Core\Rule;

abstract class IsGreaterThanRule extends Rule implements CustomValueRule
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
     * @param ContextContract $context
     * @return bool
     */
    public function evaluate(ContextContract $context)
    {
        return $this->getValue($context) > $this->floor;
    }

    /**
     * Returns an ordered array of parameters
     *
     * @return mixed
     */
    public function normalize()
    {
        return [
            'floor' => $this->floor,
        ];
    }
}