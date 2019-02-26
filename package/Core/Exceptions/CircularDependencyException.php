<?php

namespace Arbiter\Core\Exceptions;

use Arbiter\Contracts\RuleContract;
use Exception;

class CircularDependencyException extends Exception
{
    public function __construct(RuleContract $parent, RuleContract $child)
    {
        parent::__construct(sprintf(
            'Circular rule dependency detected between "%s" and "%s"',
            get_class($parent),
            get_class($child)
        ));
    }
}