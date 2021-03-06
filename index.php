<?php
require __DIR__ . '/vendor/autoload.php';

define('DATA_DIRECTORY', __DIR__ . '/data/');

use FantasyUpdater\Commands\SaveFixturesCommand;
use FantasyUpdater\Commands\SaveGameWeeksCommand;
use FantasyUpdater\Commands\SavePlayersCommand;
use FantasyUpdater\Commands\SavePositionsCommand;
use FantasyUpdater\Commands\SaveTeamsCommand;
use FantasyUpdater\Commands\TestMongoCommand;
use FantasyUpdater\Commands\UpdateCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

// Parses environment variables into $_ENV
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/config/.env');

$application = new Application();
$application->add(new UpdateCommand());
$application->add(new TestMongoCommand());
$application->add(new SaveGameWeeksCommand());
$application->add(new SaveTeamsCommand());
$application->add(new SavePlayersCommand());
$application->add(new SaveFixturesCommand());
$application->add(new SavePositionsCommand());
$application->run();


