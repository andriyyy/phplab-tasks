<?php

namespace src\oop\Commands;

class DiviCommand implements CommandInterface
{
    /**
     * @inheritdoc
     */
    public function execute(...$args)
    {
        if (2 != sizeof($args)) {
            throw new \InvalidArgumentException('Not enough parameters');
        }
        if (0 == $args[1]) {
            throw new \InvalidArgumentException('Not allowed to divide on zero');
        }

        return $args[0] / $args[1];
    }
}