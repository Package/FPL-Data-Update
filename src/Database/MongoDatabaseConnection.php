<?php

namespace FantasyUpdater\Database;

use Exception;
use MongoDB\Driver\Exception\ConnectionException;
use MongoDB\Driver\Manager;

class MongoDatabaseConnection
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * MongoDatabaseConnection constructor.
     */
    public function __construct()
    {
        // Ensure correct configuration before attempting a connection
        $this->checkConfiguration();
    }

    /**
     * Attempts to connect to MongoDB using the configuration defined in environment variables.
     *
     * @return Manager
     */
    public function manager() : Manager
    {
        $this->checkConfiguration();

        return $this->getConnection();
    }

    /**
     * Checks that the required configuration has been provided in the .env file in the root of the project.
     * This should be configured with the correct details to connect to the MongoDB instance.
     */
    private function checkConfiguration() : void
    {
        $environmentVars = ['MONGO_DB_DATABASE', 'MONGO_DB_USERNAME', 'MONGO_DB_PASSWORD', 'MONGO_DB_URI'];

        foreach ($environmentVars as $var) {
            if (!isset($_ENV[$var]) || !strlen($_ENV[$var])) {
                throw new ConnectionException("Unable to connect to database due to missing .env variables ()");
            }
        }
    }

    /**
     * Connects to a Mongo database and returns the client.
     *
     * @return Manager
     */
    private function getConnection() : Manager
    {
        if ($this->manager === null) {
            try {
                $this->manager = new Manager($_ENV['MONGO_DB_URI']);
            } catch (Exception $e) {
                exit("Error connecting to database: " . $e->getMessage());
            }
        }

        return $this->manager;
    }
}