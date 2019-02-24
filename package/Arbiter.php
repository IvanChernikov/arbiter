<?php

namespace Arbiter;

use Arbiter\Contracts\Context;
use Arbiter\Core\Builder;
use Arbiter\Core\Rule;
use Arbiter\Core\RuleBook;
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
     * Creates a new RuleBook
     * @param mixed ...$rules
     * @return RuleBook
     */
    public function rulebook(...$rules)
    {
        return new RuleBook($this, ...$rules);
    }

    public function builder()
    {
        return new Builder($this);
    }

    /**
     * @param Rule $rule
     * @return bool
     */
    public function evaluate(Rule $rule)
    {
        return key_exists($rule->getDigest(), $this->registry)
            ? $this->retrieve($rule)
            : $this->register($rule);
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