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


    public function chooseColumn(Dice $dice, Board $playerBoard): int
    {
        $myBoard = $this->getBoard();
        $availableColumns = [];

        for ($i = 0; $i < 3; $i++) {
            if (!$myBoard->canPlaceDice($i)) {
                continue;
            }

            $availableColumns[] = $i;
        }

        // 1. priority -> attack (destroy players dice)
        foreach ($availableColumns as $columnIdx) {
            if (in_array($dice->getValue(), $playerBoard->columns[$columnIdx], true)) {
                return $columnIdx;
            }
        }

        // 2. priority -> multiplying score (if you cant attack)
        foreach ($availableColumns as $columnIdx) {
            if (in_array($dice->getValue(), $myBoard->columns[$columnIdx], true)) {
                return $columnIdx;
            }
        }

        // 3. priority -> defense (place dice in empty column)
        foreach ($availableColumns as $columnIdx) {
            if (empty($myBoard->columns[$columnIdx])) {
                return $columnIdx;
            }
        }

        // fallback
        $randomIdx = array_rand($availableColumns);
        return $availableColumns[$randomIdx];
    }
}
