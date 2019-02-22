<?php

namespace Arbiter\Rules;

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
                //return false;
            }
        }

        return true;
    }

    /**
     * @return Rule[]
     */
    private function getEvaluationStack()
    {
        $rules = [];

        foreach ($this->rules as $rule) {
            $stack = [$rule];
            $current = $rule;
            while ($current || $stack) {
                array_push($rules, $current);
                $current = array_pop($stack);
                $current && array_push($stack, ...$current->getDependencies());
            }

        }

        return $rules;
    }
}
