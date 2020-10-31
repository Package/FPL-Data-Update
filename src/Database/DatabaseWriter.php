<?php


namespace FantasyUpdater\Database;


abstract class DatabaseWriter
{
    public abstract function write(string $tableName, array $data) : int;

    protected abstract function getDatabaseConnection();
}