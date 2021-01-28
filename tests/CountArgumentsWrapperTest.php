<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsWrapperTest extends TestCase
{
    public function testNegative()
    {
        $this->expectException(InvalidArgumentException::class);

        countArgumentsWrapper(['test1', 'test2', 1]);
    }
}
