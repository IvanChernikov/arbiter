<?php

namespace Arbiter\Core;

use Arbiter\Contracts\ArbiterContract;
use Arbiter\Contracts\ResultContract;
use Illuminate\Support\Arr;

final class RuleBook
{
    private $arbiter;
    private $rules;

    /**
     * RuleBook constructor.
     * @param ArbiterContract $arbiter
     * @param Rule ...$rules
     */
    public function __construct(ArbiterContract $arbiter, Rule ...$rules)
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
     * @param Rule[] $rules
     * @return Rule[]
     */
    private function expand(Rule ...$rules)
    {
        $list  = collect();
        $queue = $rules;
        while ($queue) {
            /** @var \Arbiter\Contracts\RuleContract $current */
            $current = array_pop($queue);
            $list->push($current);
            array_push($queue, ...$this->arbiter->expand($current));
        }

        return $list->reverse()->unique(function (Rule $rule) {
            return $rule->hash();
        })->all();
    }
}
