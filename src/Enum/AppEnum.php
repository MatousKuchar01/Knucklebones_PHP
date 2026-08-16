<?php

declare(strict_types=1);

namespace App\Enum;

enum AppEnum: string
{
    // intro
    case APP_TITLE = <<<'TEXT'
    <fg=yellow;options=bold>
      _  __                 _
     | |/ /_ __  _   _  ___| | _____| |__   ___  _ __   ___  ___
     | ' /| '_ \| | | |/ __| |/ / _ \ '_ \ / _ \| '_ \ / _ \/ __|
     | . \| | | | |_| | (__|   <  __/ |_) | (_) | | | |  __/\__ \
     |_|\_|_| |_|\__,_|\___|_|\_\___|_.__/ \___/|_| |_|\___||___/
    </>
    TEXT;

    case APP_INTRO = <<<'TEXT'
    Knucklebones is a tactical dice game for two players played on
    two 3x3 grids.

    RULES:
    1. On your turn, roll a single 6-sided die.
    2. Place the die into one of your 3 columns (if it has free space).
    3. MATCH & DESTROY: If you place a die in a column, all matching
       dice in the OPPONENT'S corresponding column are DESTROYED!
    4. SCORING: Dice in a column add up, but matching values get
       multiplied! (e.g. two 5s = 20 pts, three 6s = 54 pts).

    ENDGAME:
    The game ends immediately when either player completely fills
    their 3x3 grid. The player with the highest total score WINS!
    TEXT;

    // misc
    case PRESS_ENTER_TO_START = 'Press [ENTER] to start the game';
    case CURRENT_ROLL = 'Just rolled: ';
    case WAITING_ON_ROLL = 'Waiting on dice roll...';
    case JEFF_IS_THINKING = 'Jeff is thinking...';
    case YOU_WON = '<fg=green;options=bold>You won!</>';
    case JEFF_WON = '<fg=red;options=bold>Jeff won.</>';
    case DRAW = 'Its a draw.';

    case PROMPT_USER = 'Type number of column you want to place dice to:';
	case EXIT = 'exit';
	case GOODBYE = 'You exited the game:( See you again....';
}
