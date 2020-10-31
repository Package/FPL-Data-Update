<?php

namespace FantasyUpdater\Database;

use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Manager;

class MongoDatabaseWriter extends DatabaseWriter
{
    /**
     * Writes the provided data to the provided MongoDB table.
     * @param string $tableName
     * @param array $data
     * @return int
     */
    public function write(string $tableName, array $data): int
    {
        $manager = $this->getDatabaseConnection();

        $bulkWriter = new BulkWrite();

        $bulkWriter->delete([]);

        foreach ($data as $d) {
            $bulkWriter->insert($d);
        }

        $databaseAndCollection = "{$_ENV['MONGO_DB_DATABASE']}.{$tableName}";
        $manager->executeBulkWrite($databaseAndCollection, $bulkWriter);

        return count($data);
    }

    /**
     * Makes a connection to MongoDB and returns the @see Manager
     * @return Manager
     */
    protected function getDatabaseConnection() : Manager
    {
        $connection = new MongoDatabaseConnection();
        return $connection->getConnection();
    }
}