<?php

use PHPUnit\Framework\TestCase;

class GetSayHellowTest extends TestCase
{
    public function testPositive()
    {
        $this->assertEquals('Hello', sayHello());
    }
}