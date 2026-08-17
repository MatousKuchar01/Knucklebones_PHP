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

    /**
    * renders intro of the game
    * @param SymfonyStyle $io
    * @return void
    */
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
     * prompt for user to enter column
     * @param SymfonyStyle $io
     * @param callable $validator
     * @return string
     */
    public function renderUserAnswerField(SymfonyStyle $io): string
    {
       	$answer = $io->ask(AppEnum::PROMPT_USER->value, null);

		if (strtolower($answer) === AppEnum::EXIT->value) {
	    	$io->warning(AppEnum::GOODBYE->value);
		    exit;
		}

       	return (string) $answer;
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
     * renders current roll of the dice to player
     * @param Dice|Null $currentDice
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
     * colors dice based on multiplier
     * @param string $asciiLine
     * @param int $multiplier
     * @return string
     */
    private function colorizeDiceLine(string $asciiLine, int $multiplier): string
    {
        if ($multiplier === 2) {
            return str_replace('●', '<fg=yellow;options=bold>●</>', $asciiLine);
        }

        if ($multiplier >= 3) {
            return str_replace('●', '<fg=red;options=bold>●</>', $asciiLine);
        }

        return $asciiLine;
    }


    /**
    * @param SymfonyStyle $io
    * @param Board $board
    * @return void
    */
    private function renderBoard(SymfonyStyle $io, Board $board): void
    {
        for ($row = 0; $row < 3; $row++) {
            $dice1 = $board->columns[0][$row] ?? 0;
            $dice2 = $board->columns[1][$row] ?? 0;
            $dice3 = $board->columns[2][$row] ?? 0;

            $mult1 = $this->scoreService->getDiceMultiplier($board->columns[0], $dice1);
            $mult2 = $this->scoreService->getDiceMultiplier($board->columns[1], $dice2);
            $mult3 = $this->scoreService->getDiceMultiplier($board->columns[2], $dice3);

            for ($line = 0; $line < 5; $line++) {
                $line1 = $this->asciiDiceMap[$dice1][$line];
                $line2 = $this->asciiDiceMap[$dice2][$line];
                $line3 = $this->asciiDiceMap[$dice3][$line];

                $coloredLine1 = $this->colorizeDiceLine($line1, $mult1);
                $coloredLine2 = $this->colorizeDiceLine($line2, $mult2);
                $coloredLine3 = $this->colorizeDiceLine($line3, $mult3);

                $io->writeln("{$coloredLine1} {$coloredLine2} {$coloredLine3}");
            }
        }
    }

    /**
    * renders name and score of a player
    * @param SymfonyStyle $io
    * @param PlayerInterface $player
    * @return void
    */
    private function renderPlayerNameAndScore(SymfonyStyle $io, PlayerInterface $player): void
    {
        $io->writeln("{$player->getName()}" . " - Score: {$this->scoreService->getTotalPlayerScore($player->getBoard())}");
    }

    /**
     * renders column numbers behind board for player
     * @param SymfonyStyle $io
     * @return void
     */
    private function renderColumnsHintNumber(SymfonyStyle $io): void
    {
        $io->writeln("[   1   ]" . " " . "[   2   ]" . " " . "[   3   ]");
    }

    /**
    * renders victory screen after someone wins
    * @param SymfonyStyle $io
    * @param Player $player
    * @param Player_AI $ai
    * @return void
    */
    public function renderVictory(SymfonyStyle $io, Player $player, Player_AI $ai): void
    {
        $this->clearScreen($io);

        $playerScore = $this->scoreService->getTotalPlayerScore($player->getBoard());
        $aiScore = $this->scoreService->getTotalPlayerScore($ai->getBoard());

        if ($playerScore > $aiScore) {
            $io->text(AppEnum::YOU_WON->value);
        } elseif ($aiScore > $playerScore) {
            $io->text(AppEnum::JEFF_WON->value);
        } else {
            $io->text(AppEnum::DRAW->value);
        }


        $io->text("Final Score -> You: {$playerScore} | Jeff: {$aiScore}");
        $io->newLine();
     }

    /**
    * main rendering function
    * @param SymfonyStyle $io
    * @param Player $player
    * @param Player_AI $ai
    * @param Dice|null $currentDice
    * @return void
    */
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
        $this->renderColumnsHintNumber($io);
        $this->renderBoard($io, $ai->getBoard());
        $this->renderSeparatorSmall($io);
        $this->renderCurrentRoll($io, $currentDice);
        $this->renderSeparatorSmall($io);
        $this->renderBoard($io, $player->getBoard());
        $this->renderColumnsHintNumber($io);
        $this->renderPlayerNameAndScore($io, $player);
        $this->renderSeparatorBig($io);
    }

    /**
    * renders a prompt for user after the game
    * @param SymfonyStyle $io
    * @return string
    */
    public function renderPlayAgain($io): string
    {
        return $io->choice("Do you want to try again?",
            [
                'yes' => "Start new game",
                'no' => "Quit"
            ],
            'yes'
        );
    }
}
