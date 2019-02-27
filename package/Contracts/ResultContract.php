<?php

namespace Arbiter\Contracts;

use JsonSerializable;

interface ResultContract extends JsonSerializable
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
     * @return ContextContract
     */
    public function context();
}