<?php

declare(strict_types=1);

namespace App\Enum;

enum AppEnum: string
{
    // intro
    case APP_TITLE = <<<'TEXT'
    <fg=yellow;options=bold>

 __  _  ____   __ __    __  __  _  _        ___  ____    ___   ____     ___  _____
|  l/ ]|    \ |  T  T  /  ]|  l/ ]| T      /  _]|    \  /   \ |    \   /  _]/ ___/
|  ' / |  _  Y|  |  | /  / |  ' / | |     /  [_ |  o  )Y     Y|  _  Y /  [_(   \_
|    \ |  |  ||  |  |/  /  |    \ | l___ Y    _]|     T|  O  ||  |  |Y    _]\__  T
|     Y|  |  ||  :  /   \_ |     Y|     T|   [_ |  O  ||     ||  |  ||   [_ /  \ |
|  .  ||  |  |l     \     ||  .  ||     ||     T|     |l     !|  |  ||     T\    |
l__j\_jl__j__j \__,_j\____jl__j\_jl_____jl_____jl_____j \___/ l__j__jl_____j \___j
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
