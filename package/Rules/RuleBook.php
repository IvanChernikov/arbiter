<?php

namespace Arbiter\Rules;

use Arbiter\Rules\Contracts\Context;

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
        $this->rules   = $rules;
    }

    /**
     * @return bool
     */
    public function evaluate()
    {
        foreach ($this->getEvaluationStack() as $rule) {
            if (!$this->arbiter->evaluate($rule)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return Rule[]
     */
    protected function getEvaluationStack()
    {
        $rules = [];
        $stack = [];
        foreach ($this->rules as $rule) {
            array_push($stack, $rule);
            foreach ($rule->getDependents() as $dependent) {

            }
        }
    }
}
