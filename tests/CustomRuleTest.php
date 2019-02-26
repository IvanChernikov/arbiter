<?php

namespace Arbiter\Tests;

use Arbiter\Arbiter;
use Arbiter\Contracts\RuleContract;
use Arbiter\Rules\IsBetweenRule;
use Arbiter\Rules\IsEqualRule;
use Arbiter\Rules\IsGreaterThanRule;
use Arbiter\Rules\IsInArrayRule;
use Arbiter\Rules\IsLessThanRule;
use Arbiter\Rules\IsNotEqualRule;
use Arbiter\Rules\IsNotInArrayRule;
use Arbiter\Tests\Mocks\OrderedContext;
use PHPUnit\Framework\TestCase;

class CustomRuleTest extends TestCase
{
    /**
     * @param string $class custom rule base-class
     * @param array $params constructor array
     * @param mixed $value return value for CustomValueRule::getValue()
     * @return \PHPUnit\Framework\MockObject\MockObject|RuleContract
     * @throws \ReflectionException
     */
    protected function getCustomRuleMock($class, $params, $value)
    {
        $stub = $this->getMockForAbstractClass($class, $params);
        $stub->expects($this->any())
            ->method('getValue')
            ->with($this->anything())
            ->will($this->returnValue($value));
        return $stub;
    }

    /**
     * @param RuleContract ...$rules
     * @return \Arbiter\Core\RuleBook
     */
    protected function getRulebook(RuleContract ...$rules)
    {
        return (new Arbiter(new OrderedContext()))->rulebook(...$rules);
    }

    /**
     * @param RuleContract $rule
     * @param bool $expected
     */
    protected function evaluateRule(RuleContract $rule, $expected)
    {
        $rulebook = $this->getRulebook($rule);

        var_dump($rulebook);

        $this->assertEquals(
            $rulebook->evaluate(),
            $expected
        );
    }

    /**
     * @param string $class
     * @param array $params
     * @param mixed $pass
     * @param mixed $fail
     *
     * @throws \ReflectionException
     *
     * @dataProvider getCustomRuleData
     */
    public function testAllCustomRules($class, $params, $pass, $fail)
    {
        foreach ([true, false] as $expected) {
            $this->evaluateRule(
                $this->getCustomRuleMock($class, $params, $expected ? $pass : $fail),
                $expected
            );
        }
    }

    /**
     * @return array
     */
    public function getCustomRuleData()
    {
        return [
            IsBetweenRule::class     => [IsBetweenRule::class, [0, 2], 1, 3],
            IsEqualRule::class       => [IsEqualRule::class, [1], 1, 0],
            IsGreaterThanRule::class => [IsGreaterThanRule::class, [1], 2, 0],
            IsInArrayRule::class     => [IsInArrayRule::class, [[1, 2]], 1, 0],
            IsLessThanRule::class    => [IsLessThanRule::class, [1], 0, 2],
            IsNotEqualRule::class    => [IsNotEqualRule::class, [1], 0, 1],
            IsNotInArrayRule::class  => [IsNotInArrayRule::class, [[1, 2]], 0, 1],
        ];
    }

}
