<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Engine;

// php bin/console app:go
#[AsCommand(name: "app:go", description: "Runs Knucklebones")]
class GameCommand extends Command
{
    public function __construct(private Engine $engine)
    {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output,
    ): int {
        $io = new SymfonyStyle($input, $output);
        $this->engine->play($io);

        return Command::SUCCESS;
    }
}
