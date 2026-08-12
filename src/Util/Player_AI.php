<?php

declare(strict_types=1);

namespace App\Util;

use App\Interface\PlayerInterface;
use App\Util\Board;
use App\Util\Dice;

class Player_AI implements PlayerInterface
{
    public function __construct(private Board $board) {}

    public function getName(): string
    {
        return "Jeff";
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function chooseColumn(Dice $dice, Board $playerBoard) {}
}
