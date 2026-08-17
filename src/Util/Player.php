<?php

declare(strict_types=1);

namespace App\Util;

use App\Interface\PlayerInterface;
use App\Util\Board;

class Player implements PlayerInterface
{
    public function __construct(private Board $board) {}

    /** @return string */
    public function getName(): string
    {
        return "You";
    }

    /** @return Board */
    public function getBoard(): Board
    {
        return $this->board;
    }
}
