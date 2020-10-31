<?php

namespace FantasyUpdater\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class RequestHelper
{
    /**
     * Builds a new @see Client to make HTTP requests.
     *
     * @param string $baseUri
     * @return Client
     */
    public static function buildClient(string $baseUri = 'https://fantasy.premierleague.com/api/') : Client
    {
        return new Client([
            'base_uri' => $baseUri,
            'timeout' => 15.0,
            'curl' => [CURLOPT_SSL_VERIFYPEER => false]
        ]);
    }

    /**
     * Makes a request to the provided endpoint. Parses the response as JSON data.
     *
     * @param string $endpoint
     * @param Client|null $client
     * @return false|mixed
     */
    public static function makeRequest(string $endpoint, Client $client = null)
    {
        $client ??= self::buildClient();

        try {
            $response = $client->get($endpoint);
            $content = $response->getBody()->getContents();

            return json_decode($content);
        } catch (GuzzleException $e) {}

        return false;
    }
}