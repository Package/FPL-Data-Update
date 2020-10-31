<?php


namespace FantasyUpdater\Database;


use PDO;

class PostgresDatabaseWriter extends DatabaseWriter
{

    public function write(string $tableName, array $data): int
    {
        // Todo: implement
        return -1;
    }

    protected function getDatabaseConnection() : PDO
    {
        $connection = new PostgresDatabaseConnection();
        return $connection->getConnection();
    }
}