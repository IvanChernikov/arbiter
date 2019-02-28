<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\SourceRuleContract;
use Arbiter\Core\Rule;

abstract class IsGreaterThanRuleContract extends Rule implements SourceRuleContract
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
        return $this->source($context) > $this->floor;
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