<?php

declare(strict_types=1);

namespace App\Enum;

enum DiceStyle: string
{
    case DOTS = '●';
    case CROSSES = '✖';
    case STARS = '★';
    case HEARTS = '♥';
}
