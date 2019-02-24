<?php

namespace Arbiter\Builder;

use Arbiter\Contracts\Context;
use Closure;

class Predicate
{
    /** @var Closure */
    protected $value;
    /** @var Closure */
    protected $predicate;

    /**
     * Predicate constructor.
     *
     * Pass a closure that resolves a value out of the context
     *
     * @param Closure $value (Context $context)
     */
    public function __construct(Closure $value)
    {
        $this->value = $value;
    }

    /**
     * @param Context $context
     * @return bool
     */
    public function __invoke(Context $context)
    {
        $predicate = $this->predicate;
        return $predicate($context);
    }

    /**
     * Extracts value from context
     * @param Context $context
     * @return mixed
     */
    private function extract(Context $context)
    {
        $value = $this->value;
        return $value($context);
    }

    /**
     * @param array $array
     * @return static
     */
    public function in(array $array)
    {
        $this->predicate = function (Context $context) use ($array) {
            return in_array($this->extract($context), $array);
        };
        return $this;
    }

    /**
     * @param mixed $to
     * @return static
     */
    public function equals($to)
    {
        $this->predicate = function (Context $context) use ($to) {
            return $this->extract($context) == $to;
        };
        return $this;
    }

    /**
     * @param mixed $min
     * @param mixed $max
     * @return static
     */
    public function between($min, $max)
    {
        $this->predicate = function (Context $context) use ($min, $max) {
            $value = $this->extract($context);
            return $value >= $min && $value <= $max;
        };
        return $this;
    }
}