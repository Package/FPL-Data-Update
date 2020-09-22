<?php

namespace FantasyUpdater\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SavePlayersCommand extends BaseSaveCommand
{
    protected static $defaultName = "save:players";

    protected function configure()
    {
        $this->setDescription("Saves the players data into MongoDB");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entries = $this->process();
        $this->writeOutput($output, $entries);
        return Command::SUCCESS;
    }

    protected function getFileName(): string
    {
        return "players";
    }

    protected function getTableName(): string
    {
        return "players";
    }
}