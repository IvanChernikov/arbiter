<?php

namespace Arbiter\Tests;

use Arbiter\Arbiter;
use Arbiter\Tests\Mocks\TestContext;
use Arbiter\Tests\Mocks\NestedRule;
use Arbiter\Tests\Mocks\TestRule;
use PHPUnit\Framework\TestCase;

class RuleBookTest extends TestCase
{
    /**
     * Tests the order of evaluation for nested rules
     */
    public function testEvaluationStack()
    {
        $arbiter = new Arbiter(new TestContext());
        $rulebook = $arbiter->rulebook(
            new TestRule(6),
            new TestRule(7),
            new NestedRule(
                8,
                new TestRule(3),
                new TestRule(2),
                new TestRule(1)
            ),
            new NestedRule(
                9,
                new TestRule(5),
                new NestedRule(
                    4,
                    new TestRule(0)
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
        $arbiter = new Arbiter(new TestContext());
        $rule = new TestRule(1);
        $rulebook = $arbiter->rulebook($rule);

        $this->assertFalse($rulebook->evaluate());
        $this->assertNotEmpty($rulebook->getFailure());
        $this->assertEquals([
            'rule' => get_class($rule),
            'parameters' => $rule->getNormalizedParameters(),
            'digest' => $rule->getDigest(),
        ], $rulebook->getFailure());

        var_dump($rulebook->getFailure());
    }
}
