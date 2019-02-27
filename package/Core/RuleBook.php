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
        $this->rules   = $this->order(...$rules);
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
    private function order(RuleContract ...$rules)
    {
        return collect(array_reverse($rules))
            ->map(function (Rule $rule) {
                return $this->expand($rule);
            })
            ->flatten()
            ->reverse()
            ->unique(function (Rule $rule) {
                return $rule->hash();
            });
    }

    /**
     * Returns a rule and its dependencies
     *
     * @param RuleContract $rule
     * @return \Illuminate\Support\Collection
     */
    private function expand(RuleContract $rule)
    {
        $stack = [$rule];
        $tree  = collect();
        while ($stack) {
            $current = array_pop($stack);
            tap($current->hash(), function ($hash) use (&$tree, &$current) {
                if ($tree->has($hash)) {
                    throw new CircularDependencyException($tree->get($hash), $current);
                } else {
                    $tree->put($hash, $current);
                }
            });
            array_push($stack, ...$this->arbiter->expand($current));
        }
        return $tree->values();
    }
}
