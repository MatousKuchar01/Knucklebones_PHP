<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Console\Style\SymfonyStyle;
use App\Util\Dice;
use App\Util\Board;
use App\Service\ScoreService;
use App\Enum\AppEnum;
use App\Interface\PlayerInterface;
use App\Util\Player;
use App\Util\Player_AI;

class RenderService
{
    /** @var array<int, array> */
    public array $asciiDiceMap = [
        0 => [
            "┌ ․ ․ ․ ┐",
            "│       │",
            "│       │",
            "│       │",
            "└ ․ ․ ․ ┘",
        ],
        1 => [
            "┌───────┐",
            "│       │",
            "│   ●   │",
            "│       │",
            "└───────┘",
        ],
        2 => [
            "┌───────┐",
            "│ ●     │",
            "│       │",
            "│     ● │",
            "└───────┘",
        ],
        3 => [
            "┌───────┐",
            "│ ●     │",
            "│   ●   │",
            "│     ● │",
            "└───────┘",
        ],
        4 => [
            "┌───────┐",
            "│ ●   ● │",
            "│       │",
            "│ ●   ● │",
            "└───────┘",
        ],
        5 => [
            "┌───────┐",
            "│ ●   ● │",
            "│   ●   │",
            "│ ●   ● │",
            "└───────┘",
        ],
        6 => [
            "┌───────┐",
            "│ ●   ● │",
            "│ ●   ● │",
            "│ ●   ● │",
            "└───────┘",
        ],
    ];

    public function __construct(private readonly ScoreService $scoreService) {}

    /** @return void */
    public function renderIntro(SymfonyStyle $io): void
    {
        $io->title(AppEnum::APP_TITLE->value);
        $io->writeln(AppEnum::APP_INTRO->value);
        $io->ask(AppEnum::PRESS_ENTER_TO_START->value);
        $this->clearScreen($io);
    }

    /**
     * @param SymfonyStyle $io
     * @return void
     */
    private function clearScreen(SymfonyStyle $io): void
    {
        $io->write("\033[2J\033[;H");
    }

    /**
     * @param SymfonyStyle $io
     * @return void
     */
    private function renderSeparatorBig(SymfonyStyle $io): void
    {
        $io->writeln("=====================================");
    }


    /**
     * @param SymfonyStyle $io
     * @return void
     */
    private function renderSeparatorSmall(SymfonyStyle $io): void
    {
        $io->writeln("-------------------------------------");
    }

    /**
     * @param SymfonyStyle $io
     * @return void
     */
    private function renderCurrentRoll(SymfonyStyle $io, ?Dice $currentDice): void
    {
        if ($currentDice === null) {
            $io->text(AppEnum::WAITING_ON_ROLL->value);
            return;
        }

        $io->text(AppEnum::CURRENT_ROLL->value . " [{$currentDice->getValue()}]");
    }

    /**
    * @return void
    */
    private function renderBoard(SymfonyStyle $io, Board $board): void
    {
        for ($row = 0; $row < 3; $row++) {
            $dice1 = $board->columns[0][$row] ?? 0;
            $dice2 = $board->columns[1][$row]?? 0;
            $dice3 = $board->columns[2][$row] ?? 0;

            for ($line = 0; $line < 5; $line++) {
                $io->writeln(
                    $this->asciiDiceMap[$dice1][$line] . " " .
                    $this->asciiDiceMap[$dice2][$line] . " " .
                    $this->asciiDiceMap[$dice3][$line]
                );
            }
        }
    }

    private function renderPlayerNameAndScore(SymfonyStyle $io, PlayerInterface $player): void
    {

    }

    public function renderVictory(): void {}

    public function renderPlayingBoardsAndDice(
        SymfonyStyle $io,
        Player $player,
        Player_AI $ai,
        ?Dice $currentDice = null
    ): void
    {
        $this->clearScreen($io);
        $this->renderSeparatorBig($io);
        $this->renderPlayerNameAndScore($io, $ai);
        $this->renderBoard($io, $ai->getBoard());
        $this->renderSeparatorSmall($io);
        $this->renderCurrentRoll($io, $currentDice);
        $this->renderSeparatorSmall($io);
        $this->renderBoard($io, $player->getBoard());
        $this->renderPlayerNameAndScore($io, $player);
        $this->renderSeparatorBig($io);
    }
}
