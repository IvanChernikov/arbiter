<?php

namespace Arbiter\Tests;

use Arbiter\Arbiter;
use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\ResultContract;
use Arbiter\Contracts\RuleContract;
use Arbiter\Core\Result;
use Arbiter\Core\RuleBook;
use Arbiter\Tests\Mocks\IsInNestedOrder;
use Arbiter\Tests\Mocks\IsInOrder;
use Arbiter\Tests\Mocks\IsTrue;
use Arbiter\Tests\Mocks\OrderedContext;
use PHPUnit\Framework\TestCase;

class ArbiterTest extends TestCase
{
    protected function getContext()
    {
        return new OrderedContext();
    }

    public function testExpand()
    {
        $arbiter = new Arbiter($this->getContext());

        $rule = new IsInNestedOrder(
            2,
            new IsInOrder(0),
            new IsInOrder(1)
        );

        $expansion = $arbiter->expand($rule);

        $this->assertCount(2, $expansion);
        foreach ($expansion as $rule) {
            $this->assertInstanceOf(RuleContract::class, $rule);
        }
    }

    public function testApprove()
    {
        $arbiter = new Arbiter($this->getContext());

        $result = $arbiter->approve();

        $this->assertInstanceOf(ResultContract::class, $result);
        $this->assertTrue($result->success());
        $this->assertNull($result->error());
        $this->assertInstanceOf(ContextContract::class, $result->context());
    }

    public function testRefuse()
    {
        $arbiter = new Arbiter($this->getContext());

        $rule = new IsInOrder(1);

        $result = $arbiter->refuse($rule);

        $this->assertInstanceOf(ResultContract::class, $result);
        $this->assertFalse($result->success());
        $this->assertEquals($rule, $result->error());
        $this->assertInstanceOf(ContextContract::class, $result->context());
    }

    public function testRulebook()
    {
        $arbiter = new Arbiter($this->getContext());

        $rulebook = $arbiter->rulebook();

        $this->assertInstanceOf(RuleBook::class, $rulebook);
    }

    public function testEvaluate()
    {
        $arbiter = new Arbiter($this->getContext());

        $ruleTrue = new IsTrue(true);
        $this->assertTrue($arbiter->evaluate($ruleTrue));

        $ruleFalse = new IsTrue(false);
        $this->assertFalse($arbiter->evaluate($ruleFalse));
    }
}
