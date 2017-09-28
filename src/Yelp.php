<?php
/**
 * A library that interfaces with the Yelp Fusion (v3) API
 *
 * PHP version 5.6
 *
 * @category Library
 * @package  Neighborhoods\YelpFusion
 * @author   Matt Stypa <matt.stypa@55places.com>
 * @author   Rashaud Teague <rashaud.teague@55places.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/neighborhoods/Yelp-Fusion
 */

namespace Neighborhoods\YelpFusion;

use Exception;
use GuzzleHttp\Client;

/**
 * Class Yelp
 *
 * @package Neighborhoods\YelpFusion
 */
class Yelp
{
    const BASE_URI = 'https://api.yelp.com/';
    const ENDPOINT_TOKEN = 'oauth2/token';
    const ENDPOINT_SEARCH = 'v3/businesses/search';
    const GRANT_TYPE = 'client_credentials';
    const TIMEOUT_IN_SECONDS = 5;
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';

    protected $requestHeaders = [
        'cache-control' => 'no-cache',
    ];

    protected $guzzle;

    /**
     * Yelp constructor.
     *
     * @param null $handler, optional Guzzle handler to assist for testing
     */
    public function __construct($handler = null)
    {
        $options = [
            'base_uri' => self::BASE_URI,
            'timeout'  => self::TIMEOUT_IN_SECONDS,
            'headers'  => $this->requestHeaders,
        ];

        if ($handler) {
            $options['handler'] = $handler;
        }

        $this->guzzle = new Client($options);
    }

    /**
     * Gets the bearer token
     *
     * @param $clientId
     * @param $clientSecret
     * @return object
     * @throws Exception
     */
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

    /**
     * Gets the search results
     *
     * @param $terms
     * @param $bearerToken
     * @return object
     * @throws Exception
     */
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

    /**
     * Parses the response (decodes the json response)
     *
     * @param $response
     * @return object
     * @throws Exception
     */
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
