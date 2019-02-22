<?php

namespace Arbiter\Tests;

use Arbiter\Rules\Arbiter;
use Arbiter\Tests\Mocks\TestContext;
use Arbiter\Tests\Mocks\TestNestedRule;
use Arbiter\Tests\Mocks\TestRule;
use PHPUnit\Framework\TestCase;

class RuleBookTest extends TestCase
{
    public function testEvaluationStack()
    {
        $arbiter = new Arbiter(new TestContext());
        $rulebook = $arbiter->rulebook(
            new TestRule(0),
            new TestRule(1),
            new TestNestedRule(5)
        );

        $this->assertTrue($rulebook->evaluate());
    }
}
