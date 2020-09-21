<?php
require __DIR__ . '/vendor/autoload.php';

define('DATA_DIRECTORY', __DIR__ . '/data/');

use FantasyUpdater\Commands\UpdateCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

// Parses environment variables into $_ENV
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

$application = new Application();
$application->add(new UpdateCommand());
$application->run();


