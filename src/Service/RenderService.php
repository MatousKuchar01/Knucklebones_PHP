<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Console\Style\SymfonyStyle;
use App\Enum\AppEnum;

class RenderService
{
    /** @return void */
    public function renderIntro(SymfonyStyle $io): void
    {
        $io->title(AppEnum::APP_TITLE->value);
        $io->writeln(AppEnum::APP_INTRO->value);
        $io->ask(AppEnum::PRESS_ENTER_TO_START->value);
        $this->clearScreen();
    }

    /**
     * @param SymfonyStyle $io
     * @return void
     */
    public function clearScreen(SymfonyStyle $io): void
    {
        $io->write("\033[2J\033[;H");
    }

    public function renderVictory(): void {}

    public function renderPlayingBoardsAndDice(): void {}
}
