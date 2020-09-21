<?php

namespace FantasyUpdater\Commands;

use FantasyUpdater\Database\MongoDatabaseConnection;
use MongoDB\Driver\BulkWrite;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SaveGameWeeksCommand extends BaseSaveCommand
{
    protected static $defaultName = "save:gameweeks";

    protected function configure()
    {
        $this->setDescription("Saves the game week data into MongoDB");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entries = $this->process();
        $this->writeOutput($output, $entries);
        return Command::SUCCESS;
    }

    protected function getFileName(): string
    {
        return "gameweeks";
    }

    protected function getTableName(): string
    {
        return "gameweeks";
    }
}