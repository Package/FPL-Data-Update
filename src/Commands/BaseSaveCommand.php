<?php

namespace FantasyUpdater\Commands;

use FantasyUpdater\Database\MongoDatabaseConnection;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Manager;
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
     * Makes a connection to MongoDB and returns the @see Manager
     * @return Manager
     */
    protected function getDatabaseConnection() : Manager
    {
        $connection = new MongoDatabaseConnection();
        return $connection->manager();
    }

    /**
     * Processes the data write to MongoDB. Returns the number of entries inserted.
     *
     * @return int
     */
    protected function process() : int
    {
        $data = $this->loadFromFile();

        // Connect to database
        $manager = $this->getDatabaseConnection();

        // Write gameweeks
        $bulkWriter = new BulkWrite();

        // Delete any existing
        $bulkWriter->delete([]);

        // Write new ones
        foreach ($data as $d) {
            $bulkWriter->insert($d);
        }

        $databaseAndCollection = "{$_ENV['MONGO_DB_DATABASE']}.{$this->getTableName()}";
        $manager->executeBulkWrite($databaseAndCollection, $bulkWriter);

        return count($data);
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