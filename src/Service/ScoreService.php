<?php

declare(strict_types=1);

namespace App\Service;

use App\Util\Board;

class ScoreService
{
    /**
    * core mechanic -> multiplication of score by stacking numbers of same value
    * @param array $column
    * @return int
    */
    public function calculateColumnScore(array $column): int
    {
        $columnScore = 0;

        $occurancesOfNumbers = array_count_values($column);

        foreach ($occurancesOfNumbers as $value => $times) {
            $columnScore += ($value * $times) * $times;
        }

        return $columnScore;
    }


    /**
    * gets total score in all columns
    * @param Board $board
    * @return int
    */
    public function getTotalPlayerScore(Board $board): int
    {
        $totalScore = 0;

        for ($i = 0; $i < 3; $i++) {
            $totalScore += $this->calculateColumnScore($board->columns[$i]);
        }

        return $totalScore;
    }


    public function getDiceMultiplier(array $column, int $diceValue): int
    {
        if ($diceValue === 0) {
            return 1;
        }

        $counts = array_count_values($column);
        return $counts[$diceValue] ?? 1;
    }
}
