<?php

use PHPUnit\Framework\TestCase;
use src\oop\Commands\DiviCommand;

class DiviCommandTest extends TestCase
{
    /**
     * @var DiviCommand
     */
    private $command;

    /**
     * @see https://phpunit.readthedocs.io/en/9.3/fixtures.html#more-setup-than-teardown
     *
     * @inheritdoc
     */
    public function setUp(): void
    {
        $this->command = new DiviCommand();
    }

    /**
     * @return array
     */
    public function commandPositiveDataProvider()
    {
        return [
            [2, 1, 2],
            [2, 2, 1],
            [3, 2, 1.5],
        ];
    }

    /**
     * @return array
     */
    public function commandNegativeDataProvider()
    {
        return [
            [2, null],
            [2, 0]
        ];
    }

    /**
     * @dataProvider commandPositiveDataProvider
     */
    public function testCommandPositive($a, $b, $expected)
    {
        $result = $this->command->execute($a, $b);

        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider commandNegativeDataProvider
     */
    public function testCommandNegative($a, $b)
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->command->execute($a, $b);
    }

    /**
     * @see https://phpunit.readthedocs.io/en/9.3/fixtures.html#more-setup-than-teardown
     *
     * @inheritdoc
     */
    public function tearDown(): void
    {
        unset($this->command);
    }
}