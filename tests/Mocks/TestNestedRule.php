<?php

namespace Arbiter\Tests\Mocks;

class TestNestedRule extends TestRule
{

    public function getDependencies()
    {
        echo "NESTED RULE\n";
        return [
            new TestRule($this->expected - 1),
            new TestRule($this->expected - 2),
            new TestRule($this->expected - 3),
        ];
    }

}