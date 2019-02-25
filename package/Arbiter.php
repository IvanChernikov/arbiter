<?php

namespace Arbiter;

use Arbiter\Contracts\Context;
use Arbiter\Contracts\Rule;
use Arbiter\Builder\Builder;
use Arbiter\Core\RuleBook;
use Illuminate\Support\Arr;

final class Arbiter implements Contracts\Arbiter
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
     *
     * @param mixed ...$rules
     * @return RuleBook
     */
    public function rulebook(...$rules)
    {
        return new RuleBook($this, ...$rules);
    }

    /**
     * Creates a new rulebook Builder
     *
     * @return Builder
     */
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
        return Arr::has($this->registry, $rule->hash())
            ? $this->retrieve($rule)
            : $this->register($rule);
    }

    /**
     * @param Rule $rule
     * @return Rule[]
     */
    public function expand(Rule $rule)
    {
        return $rule->expand($this->context);
    }

    /**
     * @param Rule $rule
     * @return bool
     */
    private function register(Rule $rule)
    {
        return tap($rule->evaluate($this->context), function ($result) use ($rule) {
            Arr::set($this->registry, $rule->hash(), $result);
        });
    }

    /**
     * @param Rule $rule
     * @return bool
     */
    private function retrieve(Rule $rule)
    {
        return Arr::get($this->registry, $rule->hash());
    }
}