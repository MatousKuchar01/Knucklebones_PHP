<?php

declare(strict_types=1);

namespace App\Util;

use App\Interface\PlayerInterface;
use App\Util\Board;

class Player_AI implements PlayerInterface
{
    public function __construct() {}
  
    public function getName()
    {
        return "Jeff";
    }

    public function getBoard(): Board
    {
        return new Board();
    }
}
