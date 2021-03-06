<?php

namespace Arbiter\Tests;

use Arbiter\Contracts\ContextContract;
use Arbiter\Contracts\ResultContract;
use Arbiter\Contracts\RuleContract;
use Arbiter\Core\Result;
use Arbiter\Tests\Mocks\SimpleContext;
use Arbiter\Tests\Mocks\IsTrue;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    /** @var Carbon */
    private $timestamp;
    /** @var ContextContract */
    private $context;
    /** @var RuleContract */
    private $ruleTrue;
    /** @var RuleContract */
    private $ruleFalse;

    public function setUp(): void
    {
        $this->timestamp = Carbon::now();
        $this->context   = new SimpleContext($this->timestamp);
        $this->ruleTrue  = new IsTrue(true);
        $this->ruleFalse = new IsTrue(false);
    }

    public function testApproval()
    {
        $result = Result::approval($this->context);
        $this->assertInstanceOf(ResultContract::class, $result);
    }

    public function testRefusal()
    {
        $result = Result::refusal($this->ruleFalse, $this->context);
        $this->assertInstanceOf(ResultContract::class, $result);
    }

    public function testSuccess()
    {
        $approval = Result::approval($this->context);
        $this->assertTrue($approval->success());

        $refusal = Result::refusal($this->ruleFalse, $this->context);
        $this->assertFalse($refusal->success());
    }

    public function testError()
    {
        $approval = Result::approval($this->context);
        $this->assertEmpty($approval->errors());

        $refusal = Result::refusal($this->ruleFalse, $this->context);
        $this->assertInstanceOf(RuleContract::class, array_first($refusal->errors()));
    }

    public function testJsonSerialize()
    {
        $approval = Result::approval($this->context);
        $this->assertEquals([
            'success' => true,
            'errors'  => [],
            'context' => $this->context
        ], $approval->jsonSerialize());

        $refusal = Result::refusal($this->ruleFalse, $this->context);
        $this->assertEquals([
            'success' => false,
            'errors'  => [$this->ruleFalse],
            'context' => $this->context
        ], $refusal->jsonSerialize());
    }

    public function testContext()
    {
        $approval = Result::approval($this->context);
        $this->assertEquals($this->context, $approval->context());
        $this->assertInstanceOf(ContextContract::class, $approval->context());

        $refusal = Result::refusal($this->ruleFalse, $this->context);
        $this->assertEquals($this->context, $refusal->context());
        $this->assertInstanceOf(ContextContract::class, $refusal->context());
    }
}
