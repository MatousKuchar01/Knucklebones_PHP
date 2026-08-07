<?php

namespace App\Interface;

use App\Util\Board;

interface PlayerInterface
{
    /** name of the player */
    public function getName(): string;
    /** gets Board instance */
    public function getBoard(): Board;
}
