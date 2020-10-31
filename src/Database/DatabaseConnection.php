<?php


namespace FantasyUpdater\Database;


use MongoDB\Driver\Manager;
use PDO;

abstract class DatabaseConnection
{
    /**
     * @var Manager|PDO
     */
    protected $_connection = null;

    public abstract function getConnection();
    protected abstract function checkConfiguration(): void;

    public function __construct()
    {
        // Ensure correct configuration before attempting a connection
        $this->checkConfiguration();
    }
}