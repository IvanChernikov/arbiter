<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\CustomValueRule;
use Arbiter\Core\Rule;

abstract class IsInArray extends Rule implements CustomValueRule
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
        return in_array($this->getValue($context), $this->array);
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