<?php

namespace Arbiter\Contracts;

interface RuleNode
{
    /**
     * @return RuleNode
     */
    public function parent();

    /**
     * @return RuleNode[]
     */
    public function children();
}