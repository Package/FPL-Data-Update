<?php


namespace FantasyUpdater\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends Command
{
    protected static $defaultName = "fpl:update";

    protected function configure()
    {
        $this->setDescription("Pulls the latest data down from the FPL website.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("This is working");
        return Command::SUCCESS;
    }
}