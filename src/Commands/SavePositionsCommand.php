<?php

namespace FantasyUpdater\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SavePositionsCommand extends BaseSaveCommand
{
    protected static $defaultName = "save:positions";

    protected function configure()
    {
        $this->setDescription("Saves the positions data into MongoDB");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entries = $this->process();
        $this->writeOutput($output, $entries);
        return Command::SUCCESS;
    }

    protected function getFileName(): string
    {
        return "positions";
    }

    protected function getTableName(): string
    {
        return "positions";
    }
}