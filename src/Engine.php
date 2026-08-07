<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Style\SymfonyStyle;

class Engine
{
	public function __construct() {}

	/**
	 * main game loop
	 * @param SymfonyStyle $io
   * @return void
	 */
	public function play(SymfonyStyle $io): void {}
