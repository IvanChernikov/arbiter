<?php

namespace Arbiter\Tests;

use PHPUnit\Framework\TestCase;

class SanityTest extends TestCase
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
