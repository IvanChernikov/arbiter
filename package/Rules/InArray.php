<?php

namespace Arbiter\Rules;

use Arbiter\Contracts\Context;
use Arbiter\Core\Rule;

class InArray extends Rule
{
    public function __construct($array)
    {
        
    }

    /**
     * @param Context $context
     * @return bool
     */
    public function evaluate(Context $context)
    {
        // TODO: Implement evaluate() method.
    }

    /**
     * Returns a normalized array of parameters
     *
     * @return array
     */
    public function getNormalizedParameters()
    {
        // TODO: Implement getNormalizedParameters() method.
    }
}