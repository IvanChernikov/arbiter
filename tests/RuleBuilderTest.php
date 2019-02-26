<?php

namespace Arbiter\Tests;

use Arbiter\Arbiter;
use Arbiter\Builder\Template;
use Arbiter\Contracts\ResultContract;
use Arbiter\Tests\Mocks\OrderedContext;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class RuleBuilderTest extends TestCase
{
    /**
     * Tests dynamic rulebook generation
     */
    public function testEvaluation()
    {
        $arbiter = new Arbiter(new OrderedContext());
        $rulebook = $arbiter->builder()
            ->rule(function (Template $rule) {
                $rule->predicate(function (OrderedContext $context) {
                    return $context->timestamp();
                })->between(Carbon::parse('-1 day'), Carbon::parse('+1 day'));
            })
            ->rule(function (Template $rule) {
                $rule->predicate(function (OrderedContext $context) {
                    return $context->iteration();
                })->equals(0);
            })
            ->build();

        $result = $rulebook->evaluate();
        $this->assertInstanceOf(ResultContract::class, $result);
        $this->assertTrue($result->success());
    }

}
