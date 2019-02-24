<?php

namespace Arbiter\Builder;

use Arbiter\Arbiter;
use Arbiter\Core\Rule;
use Arbiter\Core\RuleBook;
use Closure;

/**
 * Class RuleBuilder
 * @package Arbiter\Core
 */
class Builder
{
    protected $arbiter;
    protected $rules;

    /**
     * Builder constructor.
     * @param Arbiter $arbiter
     */
    public function __construct(Arbiter $arbiter)
    {
        $this->arbiter = $arbiter;
        $this->rules   = [];
    }

    /**
     * @param Closure $definition (Template $template)
     * @return static
     */
    public function rule(Closure $definition)
    {
        array_push($this->rules, static::makeRule($definition));
        return $this;
    }

    /**
     * @param Closure $definition (Template $template)
     * @return Rule
     */
    public static function makeRule(Closure $definition)
    {
        return tap(new Template(), function ($template) use ($definition) {
            $definition($template);
        })->make();

    }

    /**
     * @return RuleBook
     */
    public function build()
    {
        return new RuleBook($this->arbiter, ...$this->rules);
    }
}