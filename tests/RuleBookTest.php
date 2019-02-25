<?php

namespace Arbiter\Tests;

use Arbiter\Arbiter;
use Arbiter\Tests\Mocks\IterationCountingContext;
use Arbiter\Tests\Mocks\NestedRule;
use Arbiter\Tests\Mocks\Rule;
use PHPUnit\Framework\TestCase;

class RuleBookTest extends TestCase
{
    /**
     * Tests the order of evaluation for nested rules
     */
    public function testEvaluationStack()
    {
        $arbiter = new Arbiter(new IterationCountingContext());
        $rulebook = $arbiter->rulebook(
            new Rule(6),
            new Rule(7),
            new NestedRule(
                8,
                new Rule(3),
                new Rule(2),
                new Rule(1)
            ),
            new NestedRule(
                9,
                new Rule(5),
                new NestedRule(
                    4,
                    new Rule(0)
                )
            )
        );

        $this->assertTrue($rulebook->evaluate());
    }

    /**
     * Tests failure output
     */
    public function testFailure()
    {
        $arbiter = new Arbiter(new IterationCountingContext());
        $rule = new Rule(1);
        $rulebook = $arbiter->rulebook($rule);

        var_dump($rulebook);

        $this->assertFalse($rulebook->evaluate());
    }
}
