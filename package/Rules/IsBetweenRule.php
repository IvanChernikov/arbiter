<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\CustomValueRule;
use Arbiter\Core\Rule;

abstract class IsBetweenRule extends Rule implements CustomValueRule
{
    protected $floor;
    protected $ceiling;

    /**
     * IsBetween constructor.
     * @param $floor
     * @param $ceiling
     */
    public function __construct($floor, $ceiling)
    {
        $this->floor   = $floor;
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
        $value = $this->getValue($context);
        return $value >= $this->floor && $value <= $this->ceiling;
    }

    /**
     * Returns an ordered array of parameters
     *
     * @return mixed
     */
    public function normalize()
    {
        return [
            'floor'   => $this->floor,
            'ceiling' => $this->ceiling,
        ];
    }
}