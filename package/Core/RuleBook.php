<?php

namespace Arbiter\Core;

use Arbiter\Contracts\ArbiterContract;
use Arbiter\Contracts\ResultContract;
use Arbiter\Contracts\RuleContract;
use Arbiter\Core\Exceptions\CircularDependencyException;
use Illuminate\Support\Collection;

final class RuleBook
{
    private $arbiter;
    private $rules;

    /**
     * RuleBook constructor.
     * @param ArbiterContract $arbiter
     * @param RuleContract[] $rules
     */
    private function __construct(ArbiterContract $arbiter, $rules = [])
    {
        $this->arbiter = $arbiter;
        $this->rules   = $rules;
    }

    /**
     * @param ArbiterContract $arbiter
     * @param RuleContract ...$rules
     * @return RuleBook
     * @throws CircularDependencyException
     */
    public static function make(ArbiterContract $arbiter, RuleContract ...$rules)
    {
        return new static($arbiter, static::order($arbiter, $rules));
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
     * @param ArbiterContract $arbiter
     * @param RuleContract[] $rules
     * @return RuleContract[]|Collection
     * @throws CircularDependencyException
     */
    private static function order(ArbiterContract $arbiter, array $rules = [])
    {
        $list    = collect();
        $tray    = [array_reverse($rules)];
        $parents = [];
        while ($tray) {
            $stack = array_pop($tray);
            while ($stack) {
                $current = end($stack);
                $hash    = $current->hash();

                static::detectCircularDependency($tray, $current);
                $children = in_array($hash, $parents)
                    ? []
                    : $arbiter->expand($current);

                if ($children) {
                    $parents[] = $hash;
                    array_push($tray, array_reverse($children));
                    break;
                } else {
                    $list->push(array_pop($stack));
                    if (in_array($hash, $parents)) {
                        array_pop($parents);
                    }
                }
            }

            if ($stack) {
                array_splice($tray, -1, 0, [$stack]);
            }
        }

        return $list->unique(function (Rule $rule) {
            return $rule->hash();
        });
    }

    /**
     * @param array $tray
     * @param RuleContract $rule
     * @throws CircularDependencyException
     */
    private static function detectCircularDependency(array $tray, RuleContract $rule)
    {
        $hash = $rule->hash();
        foreach ($tray as $stack) {
            $top = array_pop($stack);
            if ($top && $top->hash() === $hash) {
                throw new CircularDependencyException($top, $rule);
            }
        }
    }
}
