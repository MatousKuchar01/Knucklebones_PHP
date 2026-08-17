<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\RenderService;
use App\Util\Dice;
use App\Util\Board;
use App\Util\Player;
use App\Util\Player_AI;
use App\Enum\AppEnum;

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
        do {
            $this->renderService->renderIntro($io);
            $this->renderService->selectDiceStyle($io);

            $gameOver = false;

            $player = new Player(new Board());
            $ai = new Player_AI(new Board());

            while (!$gameOver) {
                // player turn
                $dice = new Dice();

                do {
                    $this->renderService->renderPlayingBoardsAndDice($io, $player, $ai, $dice);
                    $columnNumber = $this->renderService->renderUserAnswerField($io);
                    $playerColumn = (int)$columnNumber - 1;
                } while ($playerColumn < 0 || $playerColumn > 2 || !$player->getBoard()->canPlaceDice($playerColumn));

                $player->getBoard()->placeDice($playerColumn, $dice);
                $removedByPlayer = $ai->getBoard()->removeMatchingDice($playerColumn, $dice);

                $this->renderService->renderPlayingBoardsAndDice($io, $player, $ai, $dice);

                if ($removedByPlayer > 0) {
                    $io->text("You destroyed {$removedByPlayer}x of Jeff's dice worth {$dice->getValue()}!");
                }

                if ($player->getBoard()->isFull()) {
                    $gameOver = true;
                    break;
                }

                usleep(1_500_000);

                // ai turn
                $dice = new Dice();

                $io->text(AppEnum::JEFF_IS_THINKING->value);
                sleep(3);

                $columnNumber = $ai->chooseColumn($dice, $player->getBoard());
                $columnHumanIdx = $columnNumber + 1;

                $ai->getBoard()->placeDice((int)$columnNumber, $dice);
                $removedDiceByAi = $player->getBoard()->removeMatchingDice((int)$columnNumber, $dice);

                $this->renderService->renderPlayingBoardsAndDice($io, $player, $ai, $dice);

                if ($ai->getBoard()->isFull()) {
                    $gameOver = true;
                    break;
                }

                $io->text("Jeff placed a dice worth {$dice->getValue()} in column {$columnHumanIdx}!");

                if ($removedDiceByAi > 0) {
                    $io->text("Jeff removed your dice worth {$dice->getValue()} {$removedDiceByAi}x times!");
                }

                sleep(3);
            }

            $this->renderService->renderVictory($io, $player, $ai);
            $playAgain = $this->renderService->renderPlayAgain($io);

        } while ($playAgain == 'yes');
    }
}
