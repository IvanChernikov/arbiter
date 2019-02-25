<?php

namespace Arbiter\Tests;

use Arbiter\Arbiter;
use Arbiter\Builder\Template;
use Arbiter\Tests\Mocks\IterationCountingContext;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class RuleBuilderTest extends TestCase
{
    /**
     * Tests dynamic rulebook generation
     */
    public function testEvaluation()
    {
        $arbiter = new Arbiter(new IterationCountingContext());
        $rulebook = $arbiter->builder()
            ->rule(function (Template $rule) {
                $rule->predicate(function (IterationCountingContext $context) {
                    return $context->timestamp();
                })->between(Carbon::parse('-1 day'), Carbon::parse('+1 day'));
            })
            ->rule(function (Template $rule) {
                $rule->predicate(function (IterationCountingContext $context) {
                    return $context->iteration();
                })->equals(0);
            })
            ->build();

        $this->assertTrue($rulebook->evaluate());
    }

}
