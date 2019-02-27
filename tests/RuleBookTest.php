<?php

namespace Arbiter\Tests;

use Arbiter\Arbiter;
use Arbiter\Contracts\ResultContract;
use Arbiter\Core\Exceptions\CircularDependencyException;
use Arbiter\Core\RuleBook;
use Arbiter\Tests\Mocks\IsCircular;
use Arbiter\Tests\Mocks\IsTrue;
use Arbiter\Tests\Mocks\OrderedContext;
use Arbiter\Tests\Mocks\IsInNestedOrder;
use Arbiter\Tests\Mocks\IsInOrder;
use PHPUnit\Framework\TestCase;

class RuleBookTest extends TestCase
{
    /**
     * Tests the order of evaluation for nested rules
     * @throws CircularDependencyException
     */
    public function testExpandOrder()
    {
        $arbiter  = new Arbiter(new OrderedContext());
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

        $result = $rulebook->evaluate();

        $this->assertInstanceOf(ResultContract::class, $result);
        $this->assertTrue($result->success());
    }

    /**
     * Tests failure output
     * @throws CircularDependencyException
     */
    public function testFailure()
    {
        $arbiter  = new Arbiter(new OrderedContext());
        $rule     = new IsTrue(false);
        $rulebook = $arbiter->rulebook($rule);

        $result = $rulebook->evaluate();

        $this->assertInstanceOf(ResultContract::class, $result);
        $this->assertFalse($result->success());
    }

    /**
     * Tests circular dependency in the rule tree
     * @throws CircularDependencyException
     */
    public function testCircularDependencyException()
    {
        $arbiter = new Arbiter(new OrderedContext());
        $rule    = new IsCircular();
        $name    = get_class($rule);

        $this->expectExceptionMessage(sprintf(
            CircularDependencyException::MESSAGE_FORMAT,
            $name,
            $name
        ));

        $this->expectException(CircularDependencyException::class);
        $arbiter->rulebook($rule)->evaluate();
    }

    /**
     * Tests that repetitive rules do not get detected as circular dependencies
     * @throws CircularDependencyException
     */
    public function testRepetitiveRule()
    {
        $arbiter = new Arbiter(new OrderedContext());
        $rule = new IsTrue(true);
        $rulebook = $arbiter->rulebook(
            new IsInNestedOrder(
                0,
                $rule,
                $rule
            )
        );

        $result = $rulebook->evaluate();
        $this->assertTrue($result->success());
    }
}
