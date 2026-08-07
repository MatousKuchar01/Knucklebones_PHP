<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\RenderService;

class Engine
{
    private RenderService $renderService
    
	public function __construct(RenderService $renderService) {}

	/**
	 * main game loop
	 * @param SymfonyStyle $io
   * @return void
	 */
	public function play(SymfonyStyle $io): void 
    {
        $gameOver = false;

        while (!$gameOver) {
            
        }

        $this->renderService->clearScreen();
        $this->renderService->renderVictory();
    }
