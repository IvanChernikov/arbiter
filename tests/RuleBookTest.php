<?php

namespace Arbiter\Tests;

use Arbiter\Arbiter;
use Arbiter\Tests\Mocks\IterationCountingContext;
use Arbiter\Tests\Mocks\IsInNestedOrder;
use Arbiter\Tests\Mocks\IsInOrder;
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
            new IsInOrder(0),
            new IsInOrder(1),
            new IsInNestedOrder(
                5,
                new IsInOrder(2),
                new IsInOrder(3),
                new IsInOrder(4)
            ),
            new IsInNestedOrder(
                9,
                new IsInOrder(6),
                new IsInNestedOrder(
                    8,
                    new IsInOrder(7)
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
        $rule = new IsInOrder(1);
        $rulebook = $arbiter->rulebook($rule);

        var_dump($rulebook);

        $this->assertFalse($rulebook->evaluate());
    }
}
