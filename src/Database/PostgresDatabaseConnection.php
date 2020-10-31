<?php

namespace FantasyUpdater\Database;

use PDO;
use PDOException;

class PostgresDatabaseConnection extends DatabaseConnection
{
    protected function checkConfiguration(): void
    {
        $environmentVars = ['POSTGRES_HOST', 'POSTGRES_PORT', 'POSTGRES_DATABASE', 'POSTGRES_USERNAME', 'POSTGRES_PASSWORD'];

        foreach ($environmentVars as $var) {
            if (!isset($_ENV[$var]) || !strlen($_ENV[$var])) {
                throw new PDOException("Unable to connect to database due to missing .env variable {$var}.");
            }
        }
    }

    public function getConnection() : PDO
    {
        if ($this->_connection === null) {
            try {
                $connectionString = "pgsql:host={$_ENV['POSTGRES_HOST']};port={$_ENV['POSTGRES_PORT']};dbname={$_ENV['POSTGRES_DATABASE']};user={$_ENV['POSTGRES_USERNAME']};password={$_ENV['POSTGRES_PASSWORD']}";
                $this->_connection = new PDO($connectionString);
                $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                exit("Error connecting to database: " . $e->getMessage());
            }
        }

        return $this->_connection;
    }
}