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

        $player = new Player(new Board());
        $ai = new Player_AI(new Board());

        while (!$gameOver) {
            // player turn
            $dice = new Dice();
            $this->renderService->renderPlayingBoardsAndDice($io, $player, $ai, $dice);
            $columnNumber = $this->renderService->renderUserAnswerField($io);

            $player->getBoard()->placeDice((int)$columnNumber - 1, $dice);
            $ai->getBoard()->removeMatchingDice((int)$columnNumber, $dice);

            if ($player->getBoard()->isFull()) {
                $gameOver = true;
                break;
            }

            // ai turn
            $dice = new Dice();
            //$columnNumber = $ai->chooseColumn($dice, $player->getBoard());

            $ai->getBoard()->placeDice((int)$columnNumber - 1, $dice);
            $player->getBoard()->removeMatchingDice((int)$columnNumber, $dice);

            if ($ai->getBoard()->isFull()) {
                $gameOver = true;
                break;
            }
        }

        $this->renderService->clearScreen();
        $this->renderService->renderVictory();
    }
}
