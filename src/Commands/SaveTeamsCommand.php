<?php

namespace FantasyUpdater\Commands;

use MongoDB\Driver\BulkWrite;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SaveTeamsCommand extends BaseSaveCommand
{
    protected static $defaultName = "save:teams";

    protected function configure()
    {
        $this->setDescription("Saves the teams data into MongoDB");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entries = $this->process();
        $this->writeOutput($output, $entries);
        return Command::SUCCESS;
    }

    protected function getFileName(): string
    {
        return "teams";
    }

    protected function getTableName(): string
    {
        return "teams";
    }
}