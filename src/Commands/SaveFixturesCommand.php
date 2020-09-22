<?php

namespace FantasyUpdater\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SaveFixturesCommand extends BaseSaveCommand
{
    protected static $defaultName = "save:fixtures";

    protected function configure()
    {
        $this->setDescription("Saves the fixtures data into MongoDB");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entries = $this->process();
        $this->writeOutput($output, $entries);
        return Command::SUCCESS;
    }

    protected function getFileName(): string
    {
        return "fixtures";
    }

    protected function getTableName(): string
    {
        return "fixtures";
    }
}