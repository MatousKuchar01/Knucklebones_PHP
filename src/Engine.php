<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\RenderService;

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

        while (!$gameOver) {
            //todo
        }

        $this->renderService->clearScreen();
        $this->renderService->renderVictory();
    }
}
