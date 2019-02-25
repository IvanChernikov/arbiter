<?php

namespace Arbiter\Core;

use Arbiter\Contracts\Arbiter;
use Arbiter\Contracts\Result;

final class RuleBook
{
    private $arbiter;
    private $rules;

    /**
     * RuleBook constructor.
     * @param Arbiter $arbiter
     * @param Rule ...$rules
     */
    public function __construct(Arbiter $arbiter, Rule ...$rules)
    {
        $this->arbiter = $arbiter;
        $this->rules   = $this->expand(...$rules);
    }

    /**
     * Evaluates the rule stack
     * Evaluation is deferred to the Arbiter
     *
     * @return Result
     */
    public function evaluate()
    {
        foreach ($this->rules as $rule) {
            if (!$this->arbiter->evaluate($rule)) {
                return false;
            }
        }

        return true;
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
        $list  = [];
        $queue = $rules;
        while ($queue) {
            /** @var \Arbiter\Contracts\Rule $current */
            $current = array_pop($queue);
            array_push($list, $current);
            array_push($queue, ...$this->arbiter->expand($current));
        }

        return array_reverse($list);
    }
}
