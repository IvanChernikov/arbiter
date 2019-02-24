<?php

namespace Arbiter\Rules;

final class RuleBook
{
    private $arbiter;
    private $rules;
    private $failure;

    /**
     * RuleBook constructor.
     * @param Arbiter $arbiter
     * @param Rule ...$rules
     */
    public function __construct(Arbiter $arbiter, Rule ...$rules)
    {
        $this->arbiter = $arbiter;
        $this->rules   = $rules;
        $this->failure = [];
    }

    /**
     * @return bool
     */
    public function evaluate()
    {
        foreach ($this->getStack() as $rule) {
            if (!$this->arbiter->evaluate($rule)) {
                $this->setFailure($rule);
                return false;
            }
        }

        return true;
    }

    /**
     * Iterates through rules and creates the evaluation stack
     * Dependencies get evaluated first
     *
     * @return Rule[]
     */
    private function getStack()
    {
        $queue = [];
        $stack = [];

        array_push($queue, ...$this->rules);
        while ($queue) {
            $current = array_pop($queue);
            array_push($stack, $current);
            foreach ($current->getDependencies() as $rule) {
                array_unshift($queue, $rule);
            }
        }

        return array_reverse($stack);
    }

    /**
     * @param Rule $rule
     */
    private function setFailure(Rule $rule)
    {
        $this->failure = [
            'rule' => get_class($rule),
            'parameters' => $rule->getNormalizedParameters(),
            'digest' => $rule->getDigest(),
        ];
    }

    /**
     * @return array
     */
    public function getFailure()
    {
        return $this->failure;
    }
}
