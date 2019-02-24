<?php

namespace Arbiter\Tests;

use Arbiter\Contracts\Context;
use Arbiter\Arbiter;
use Arbiter\Builder\Template;
use Arbiter\Tests\Mocks\TestContext;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class RuleBuilderTest extends TestCase
{
    public function testEvaluation()
    {
        $arbiter = new Arbiter(new TestContext());
        $rulebook = $arbiter->builder()
            ->rule(function (Template $rule) {
                $rule->predicate(function (TestContext $context) {
                    return $context->timestamp();
                })->between(Carbon::parse('-1 day'), Carbon::parse('+1 day'));
            })
            ->rule(function (Template $rule) {
                $rule->predicate(function (TestContext $context) {
                    return $context->iteration();
                })->equals(0);
            })
            ->build();

        $this->assertTrue($rulebook->evaluate());

        var_dump($rulebook);
    }

}