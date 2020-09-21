<?php

namespace FantasyUpdater\Commands;

use DateTime;
use Exception;
use FantasyUpdater\Database\MongoDatabaseConnection;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestMongoCommand extends Command
{
    protected static $defaultName = "test:mongo";

    protected function configure()
    {
        $this->setDescription("Tests that a connection can be successfully made to MongoDB");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $connection = new MongoDatabaseConnection();
            $manager = $connection->manager();
            $this->mongoExampleCommands($manager, $output);
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * Examples of inserting, updating, deleting and listing data using this Mongo driver.
     *
     * @param Manager $database
     * @param OutputInterface $output
     * @throws \MongoDB\Driver\Exception\Exception
     */
    private function mongoExampleCommands(Manager $database, OutputInterface $output) : void
    {
        /*
         * With this Mongo driver you specify the exact path (database + collection) on any
         * queries or operations, rather than when connecting specifying which database to use.
         */
        $databaseNameAndCollectionName = "{$_ENV['MONGO_DB_TEST_DATABASE']}.items";

        /*
         * When running multiple operations at once, e.g. adding, updating or deleting you can
         * use a BulkWrite
         */
        $bulk = new BulkWrite;

        // Inserting new record to collection
        $newItem = ['date' => new DateTime, 'name' => 'Cheese'];
        $bulk->insert($newItem);

        /*
         * Updating an entry.
         * Changing the entry where the name is "Soup" to "Orange"
         */
        $bulk->update(['name' => 'Soup'], ['$set' => ['name' => 'Orange']]);

        /*
         * Deleting an entry.
         * Where the name is "Cheese"
         */
        $bulk->delete(['name' => 'Cheese']);

        /*
         * Run the bulk operations that have been scheduled (insert, update, delete)
         */
        $database->executeBulkWrite($databaseNameAndCollectionName, $bulk);

        // Listing all from a collection
        $query = new Query([]);
        $items = $database->executeQuery($databaseNameAndCollectionName, $query);
        foreach ($items as $i) {
            $output->writeln("Item: " . $i->name);
        }
    }
}