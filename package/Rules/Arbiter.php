<?php

namespace Arbiter\Rules;

use Arbiter\Rules\Contracts\Context;
use Illuminate\Support\Arr;

final class Arbiter
{
    /**
     * @var array|bool[]
     */
    private $registry = [];

    /**
     * @var Context
     */
    private $context;

    /**
     * Arbiter constructor.
     *
     * Oversees rule evaluation over single context
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @param Rule $rule
     * @return bool
     */
    public function evaluate(Rule $rule)
    {
        return key_exists($rule->getDigest(), $this->registry)
            ? $this->register($rule)
            : $this->retrieve($rule);
    }

    /**
     * @param Rule $rule
     * @return bool
     */
    private function register(Rule $rule)
    {
        return tap($rule->evaluate($this->context), function ($result) use ($rule) {
            Arr::set($this->registry, $rule->getDigest(), $result);
        });
    }

    /**
     * @param Rule $rule
     * @return bool
     */
    private function retrieve(Rule $rule)
    {
        return Arr::get($this->registry, $rule->getDigest());
    }
}