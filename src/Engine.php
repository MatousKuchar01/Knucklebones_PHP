<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\RenderService;
use App\Util\Dice;
use App\Util\Board;
use App\Util\Player;
use App\Util\Player_AI;

class Engine
{
	public function __construct(private RenderService $renderService) {}

	/**
	 * main game loop
	 * @param SymfonyStyle $io
   * @return void
	 */
	public function play(SymfonyStyle $io): void
    {
        $this->renderService->renderIntro($io);

        $gameOver = false;

        $board = new Board();
        $dice = new Dice();

        $player = new Player($board);
        $ai = new Player_AI($board);

        $this->renderService->renderPlayingBoardsAndDice($io, $player, $ai, $dice);

        while (!$gameOver) {

        }

        $this->renderService->clearScreen();
        $this->renderService->renderVictory();
    }
}
