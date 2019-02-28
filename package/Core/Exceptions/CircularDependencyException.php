<?php

namespace Arbiter\Core\Exceptions;

use Arbiter\Contracts\RuleContract;
use Exception;

class CircularDependencyException extends Exception
{
    const MESSAGE_FORMAT = 'Circular rule dependency detected between "%s" and "%s"';

    public function __construct(RuleContract $parent, RuleContract $child)
    {
        parent::__construct(sprintf(
            self::MESSAGE_FORMAT,
            get_class($parent),
            get_class($child)
        ));
    }
}