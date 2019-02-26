<?php

namespace Arbiter\Contracts;

interface ResultContract
{
    /**
     * Returns if the evaluation passed
     *
     * @return bool
     */
    public function success();

    /**
     * Returns a Rule object that failed validation
     *
     * @return RuleContract|null
     */
    public function error();

    /**
     * Returns a JSON serializable Context object
     *
     * @return string
     */
    public function context();
}