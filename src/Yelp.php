<?php

namespace Neighborhoods\Libraries;

use Exception;
use GuzzleHttp\Client;

class Yelp
{
    const BASE_URI = 'https://api.yelp.com/';
    const ENDPOINT_TOKEN = 'oauth2/token';
    const ENDPOINT_SEARCH = 'v3/businesses/search';
    const GRANT_TYPE = 'client_credentials';
    const TIMEOUT_IN_SECONDS = 5;
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const REQUEST_HEADERS = [
        'cache-control' => 'no-cache',
    ];

    protected $guzzle;

    public function __construct($handler = null)
    {
        $options = [
            'base_uri' => self::BASE_URI,
            'timeout'  => self::TIMEOUT_IN_SECONDS,
            'headers'  => self::REQUEST_HEADERS,
        ];

        if ($handler) {
            $options['handler'] = $handler;
        }

        $this->guzzle = new Client($options);
    }

    public function getBearerTokenObject($clientId, $clientSecret)
    {
        return $this->parseResponse(
            $this->guzzle->post(
                self::ENDPOINT_TOKEN,
                [
                    'form_params' => [
                        'client_id'     => $clientId,
                        'client_secret' => $clientSecret,
                        'client_type'   => self::GRANT_TYPE,
                    ],
                ]
            )
        );
    }

    public function search($terms, $bearerToken)
    {
        return $this->parseResponse(
            $this->guzzle->get(
                self::ENDPOINT_SEARCH,
                [
                    'headers' => [
                        'authorization' => 'Bearer ' . $bearerToken,
                    ],
                    'query'   => $terms,
                ]
            )
        );
    }

    protected function parseResponse($response)
    {
        if ($response->getStatusCode() !== 200) {
            throw new Exception('Invalid response');
        }

        $parsedResponse = json_decode($response->getBody());

        if (!$parsedResponse) {
            throw new Exception('Unable to parse response');
        }

        return $parsedResponse;
    }
}

