<?php

namespace FantasyUpdater\Commands;

use FantasyUpdater\Helper\RequestHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends Command
{
    protected static $defaultName = 'fpl:update';

    private const DATA_OPTIONS = ['all', 'teams', 'players', 'fixtures', 'gameweeks'];

    private const TEAMS_FILE_NAME = 'teams.json';
    private const PLAYERS_FILE_NAME = 'players.json';
    private const POSITIONS_FILE_NAME = 'positions.json';
    private const GAMEWEEKS_FILE_NAME = 'gameweeks.json';
    private const FIXTURES_FILE_NAME = 'fixtures.json';

    protected function configure()
    {
        $this->setDescription('Pulls the latest data down from the FPL website.');
        $this->setHelp('Run as: php index.php fpl:update data_to_update (one of: [all, teams, players, fixtures, gameweeks])');
        $this->addArgument('data', InputArgument::REQUIRED,
            'Specify the data that should be fetched, one of: [all, teams, players, fixtures, gameweeks]');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*
         * Retrieve arguments and validate
         */

        $dataToUpdate = $input->getArgument('data');
        if (!in_array($dataToUpdate, self::DATA_OPTIONS)) {
            $output->writeln("Unknown option: {$dataToUpdate}.");
            return Command::FAILURE;
        }

        /*
         * Make the requests to fetch the data.
         */

        $data = $this->getData('bootstrap-static/', $output);
        if ($data === false) {
            return Command::FAILURE;
        }

        /*
         * Write the appropriate data to the output file(s)
         */

        if (in_array($dataToUpdate, ['all', 'teams'])) {
            $this->saveToFile(UpdateCommand::TEAMS_FILE_NAME, $data->teams, $output);
        }
        if (in_array($dataToUpdate, ['all', 'players'])) {
            $this->saveToFile(UpdateCommand::PLAYERS_FILE_NAME, $data->elements, $output);
        }
        if (in_array($dataToUpdate, ['all', 'positions'])) {
            $this->saveToFile(UpdateCommand::POSITIONS_FILE_NAME, $data->element_types, $output);
        }
        if (in_array($dataToUpdate, ['all', 'gameweeks'])) {
            $this->saveToFile(UpdateCommand::GAMEWEEKS_FILE_NAME, $data->events, $output);
        }
        if (in_array($dataToUpdate, ['all', 'fixtures'])) {
            // Fixture data lives at another end-point so an additional request is needed:
            $data = $this->getData('fixtures/', $output);
            $this->saveToFile(UpdateCommand::FIXTURES_FILE_NAME, $data, $output);
        }

        return Command::SUCCESS;
    }

    /**
     * Makes the HTTP requests to fetch the data from provided endpoint.
     *
     * @param string $endpoint
     * @param OutputInterface $output
     * @return false
     */
    private function getData(string $endpoint, OutputInterface $output)
    {
        $client = RequestHelper::buildClient();
        $data = RequestHelper::makeRequest($endpoint, $client);
        if (!is_object($data) && !is_array($data)) {
            $output->writeln('An error occurred making the HTTP request.');
            return false;
        }

        return $data;
    }

    /**
     * Writes the provided data in JSON format to the provided output file.
     *
     * @param string $filename
     * @param array $data
     * @param OutputInterface $output
     */
    private function saveToFile(string $filename, array $data, OutputInterface $output) : void
    {
        file_put_contents(DATA_DIRECTORY . $filename, json_encode($data));
        $output->writeln('Saved ' . count($data) . ' records to ' . $filename);
    }
}