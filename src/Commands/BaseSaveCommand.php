<?php

namespace FantasyUpdater\Commands;

use Exception;
use FantasyUpdater\Database\MongoDatabaseWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseSaveCommand extends Command
{
    protected abstract function getFileName() : string;
    protected abstract function getTableName(): string;

    /**
     * Attempts to load the JSON data from the data file.
     *
     * @return array
     * @throws Exception
     */
    protected function loadFromFile() : array
    {
        $file = DATA_DIRECTORY . '/' . $this->getFileName() . '.json';

        if (!file_exists($file)) {
            throw new Exception("Unable to locate data file: " . $this->getFileName() . '.json');
        }

        $fileContent = file_get_contents($file);
        return json_decode($fileContent);
    }

    /**
     * Writes the data to the database. Returns the number of entries inserted.
     *
     * @return int
     * @throws Exception
     */
    protected function process() : int
    {
        $data = $this->loadFromFile();
        $writer = new MongoDatabaseWriter();
        return $writer->write($this->getTableName(), $data);
    }

    /**
     * Writes to the @see OutputInterface the number of entries inserted in this save.
     *
     * @param OutputInterface $output
     * @param int $count
     */
    protected function writeOutput(OutputInterface $output, int $count) : void
    {
        $output->writeln("Wrote {$count} to the {$this->getTableName()} table.");
    }
}