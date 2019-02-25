<?php

namespace Arbiter\Tests;

use Arbiter\Arbiter;
use Arbiter\Contracts\Rule;
use Arbiter\Rules\IsBetween;
use Arbiter\Rules\IsEqual;
use Arbiter\Rules\IsGreaterThan;
use Arbiter\Rules\IsInArray;
use Arbiter\Rules\IsLessThan;
use Arbiter\Rules\IsNotEqual;
use Arbiter\Rules\IsNotInArray;
use Arbiter\Tests\Mocks\OrderedContext;
use PHPUnit\Framework\TestCase;

class CustomRuleTest extends TestCase
{
    /**
     * @param string $class custom rule base-class
     * @param array $params constructor array
     * @param mixed $value return value for CustomValueRule::getValue()
     * @return \PHPUnit\Framework\MockObject\MockObject|Rule
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
     * @param Rule ...$rules
     * @return \Arbiter\Core\RuleBook
     */
    protected function getRulebook(Rule ...$rules)
    {
        return (new Arbiter(new OrderedContext()))->rulebook(...$rules);
    }

    /**
     * @param Rule $rule
     * @param bool $expected
     */
    protected function evaluateRule(Rule $rule, $expected)
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
            IsBetween::class     => [IsBetween::class, [0, 2], 1, 3],
            IsEqual::class       => [IsEqual::class, [1], 1, 0],
            IsGreaterThan::class => [IsGreaterThan::class, [1], 2, 0],
            IsInArray::class     => [IsInArray::class, [[1, 2]], 1, 0],
            IsLessThan::class    => [IsLessThan::class, [1], 0, 2],
            IsNotEqual::class    => [IsNotEqual::class, [1], 0, 1],
            IsNotInArray::class  => [IsNotInArray::class, [[1, 2]], 0, 1],
        ];
    }

}
