<?php

declare(strict_types=1);

namespace App\Util;

class Board
{
		/** @var int */
		public const COLUMN_DICE_LIMIT = 3;
        /** @var int */
		public const FULL_COLUMNS_LIMIT = 3;
		/** @var array<int, array> */
		public array $columns = [
			0 => [],
			1 => [],
			2 => [],
		];
	
		public function __construct() {}

		/**
		* if one player fills the board, the game is over
		* @return bool 
		*/
		public function isFull(): bool 
		{
				$fullColumnsCount = 0;
			
				for ($i = 0; $i < 3; $i++) {
						 if (sizeof($this->columns[$i]) === self::COLUMN_DICE_LIMIT) {
							 	$fullColumnsCount++;
						 }
				}

				return $fullColumnsCount === self::FULL_COLUMNS_LIMIT;
		}

		public function canPlaceDice(): bool {}

		public function placeDice() {}
}
