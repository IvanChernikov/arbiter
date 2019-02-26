<?php

namespace Arbiter\Core;

use Arbiter\Contracts\ArbiterContract;
use Arbiter\Contracts\ResultContract;
use Arbiter\Contracts\RuleContract;
use Arbiter\Core\Exceptions\CircularDependencyException;
use Illuminate\Support\Arr;

final class RuleBook
{
    private $arbiter;
    private $rules;

    /**
     * RuleBook constructor.
     * @param ArbiterContract $arbiter
     * @param RuleContract ...$rules
     */
    public function __construct(ArbiterContract $arbiter, RuleContract ...$rules)
    {
        $this->arbiter = $arbiter;
        $this->rules   = $this->expand(...$rules);
    }

    /**
     * Evaluates the rule stack
     * Evaluation is deferred to the Arbiter
     *
     * @return ResultContract
     */
    public function evaluate()
    {
        foreach ($this->rules as $rule) {
            if (!$this->arbiter->evaluate($rule)) {
                return $this->arbiter->refuse($rule);
            }
        }

        return $this->arbiter->approve();
    }

    /**
     * Iterates through rules and creates the evaluation stack
     * Dependencies get evaluated first
     *
     * @param RuleContract[] $rules
     * @return RuleContract[]
     */
    private function expand(RuleContract ...$rules)
    {
        $list = collect();
        while ($rules) {
            $stack = [array_pop($rules)];
            $tree  = collect();
            while ($stack) {
                $current = array_pop($stack);
                tap($tree->count(), function ($count) use ($tree, $current) {
                    if ($count === $tree->put($current->hash(), $current)) {
                        throw new CircularDependencyException()
                    }
                    Arr::has($tree, $hash)
                        ? Arr::set($tree, $hash, null)
                        : ;
                });

            }
        }


        $stack = $rules;
        while ($stack) {
            /** @var \Arbiter\Contracts\RuleContract $current */
            $current = array_pop($stack);
            $list->push($current);
            array_push($tray, ...$this->arbiter->expand($current));
        }

        return $list->reverse()->unique(function (Rule $rule) {
            return $rule->hash();
        })->all();
    }

    /**
     * Detects circular dependencies between rules
     *
     * @param RuleContract $parent
     * @param RuleContract ...$children
     * @return RuleContract[]
     */
    private function validateExpansion(RuleContract $parent, RuleContract ...$children)
    {
        collect($children)->each(function (RuleContract $rule) use ($parent) {
            if ($rule->hash() === $parent->hash()) {
                throw new CircularDependencyException($parent, $rule);
            }
        });
        return $children;
    }
}
