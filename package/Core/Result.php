<?php

namespace Arbiter\Core;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\ResultContract;
use Arbiter\Contracts\RuleContract;
use Illuminate\Support\Arr;

final class Result implements ResultContract
{
    /** @var array */
    private $data;

    /**
     * Result constructor.
     * @param bool $success
     * @param ContextContract $context
     * @param RuleContract $error
     */
    private function __construct($success, ContextContract $context, RuleContract $error = null)
    {
        $this->data = compact('success', 'error', 'context');
    }

    /**
     * @param ContextContract $context
     * @return static
     */
    public static function approval(ContextContract $context)
    {
        return new static(true, $context);
    }

    /**
     * @param RuleContract $rule
     * @param ContextContract $context
     * @return static
     */
    public static function refusal(RuleContract $rule, ContextContract $context)
    {
        return new static(false, $context, $rule);
    }

    /**
     * Returns if the evaluation passed
     *
     * @return bool
     */
    public function success()
    {
        return Arr::get($this->data, 'success');
    }

    /**
     * Returns a Rule object that failed validation
     *
     * @return RuleContract
     */
    public function error()
    {
        return Arr::get($this->data, 'error');
    }

    /**
     * Returns a JSON serialized Context object
     *
     * @return string
     */
    public function context()
    {
        return Arr::get($this->data, 'context');
    }
}