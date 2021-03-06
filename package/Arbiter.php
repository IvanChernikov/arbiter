<?php

namespace Arbiter;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\RuleContract;
use Arbiter\Core\Result;
use Arbiter\Core\RuleBook;
use Illuminate\Support\Arr;

final class Arbiter implements Contracts\ArbiterContract
{
    /**
     * @var array|bool[]
     */
    private $registry = [];

    /**
     * @var ContextContract
     */
    private $context;

    /**
     * Arbiter constructor.
     *
     * Oversees rule evaluation over single context
     *
     * @param ContextContract $context
     */
    public function __construct(ContextContract $context)
    {
        $this->context = $context;
    }

    /**
     * Creates a new RuleBook
     *
     * @param mixed ...$rules
     * @return RuleBook
     * @throws Core\Exceptions\CircularDependencyException
     */
    public function rulebook(...$rules)
    {
        return RuleBook::make($this, ...$rules);
    }

    /**
     * @param RuleContract $rule
     * @return bool
     */
    public function evaluate(RuleContract $rule)
    {
        return Arr::has($this->registry, $rule->hash())
            ? $this->retrieve($rule)
            : $this->register($rule);
    }

    /**
     * @param RuleContract $rule
     * @return RuleContract[]
     */
    public function expand(RuleContract $rule)
    {
        return $rule->expand($this->context);
    }

    /**
     * Refuses a rulebook
     *
     * @param RuleContract $rule
     * @return Contracts\ResultContract|Result
     */
    public function refuse(RuleContract $rule)
    {
        return Result::refusal($rule, $this->context);
    }

    /**
     * Approves a rulebook
     *
     * @return Contracts\ResultContract|Result
     */
    public function approve()
    {
        return Result::approval($this->context);
    }

    /**
     * @param RuleContract $rule
     * @return bool
     */
    private function register(RuleContract $rule)
    {
        return tap($rule->evaluate($this->context), function ($result) use ($rule) {
            Arr::set($this->registry, $rule->hash(), $result);
        });
    }

    /**
     * @param RuleContract $rule
     * @return bool
     */
    private function retrieve(RuleContract $rule)
    {
        return Arr::get($this->registry, $rule->hash());
    }
}