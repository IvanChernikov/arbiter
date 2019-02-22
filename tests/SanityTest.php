<?php

namespace Arbiter\Tests;

class SanityTest extends \PHPUnit_Framework_TestCase
{
    public function testHelloWorld()
    {
        $array = [
            'Hello',
            'World!',
        ];

        $this->assertEquals('Hello World!', implode(' ', $array));
    }
}
