<?php

namespace App\Util;

class Dice
{
    /** @var int */
    private int $value; // 1 to 6
    /** @var int */
    private readonly int $sides = 6;
  
    public function __construct() { $this->roll(); }

    /**
    * rolls a random number
    * @return int 
    */
    public function roll(): int
    {
        $this->value = random_int(1, $this->sides);
        return $this->value;
    }

    /** @return int */
    public function getValue(): int
    {
        return $this->value;
    }
}
