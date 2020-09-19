<?php
require __DIR__ . '/vendor/autoload.php';

use FantasyUpdater\Commands\UpdateCommand;
use Symfony\Component\Console\Application;
//use Monolog\Handler\StreamHandler;
//use Monolog\Logger;

//$logger = new Logger('appLogger');
//$logger->pushHandler(new StreamHandler(__DIR__ . '/log/app.log', Logger::INFO));
//$logger->log(Logger::INFO, 'this is up and running.');

$application = new Application();
$application->add(new UpdateCommand());
$application->run();


