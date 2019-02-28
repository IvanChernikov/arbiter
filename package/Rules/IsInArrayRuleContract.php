<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\SourceRuleContract;
use Arbiter\Core\Rule;

abstract class IsInArrayRuleContract extends Rule implements SourceRuleContract
{
    protected $array = [];

    /**
     * InArray constructor.
     * @param $array
     */
    public function __construct($array)
    {
        $this->array = $array;
        sort($this->array);
    }

    /**
     * @param ContextContract $context
     * @return bool
     */
    public function evaluate(ContextContract $context)
    {
        return in_array($this->source($context), $this->array);
    }

    /**
     * Returns a normalized array of parameters
     *
     * @return array
     */
    public function normalize()
    {
        return [
            'array' => implode(',', $this->array),
        ];
    }
}