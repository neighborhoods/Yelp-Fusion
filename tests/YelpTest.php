<?php
/**
 * Test suite for the Yelp library
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

namespace Neighborhoods\YelpFusion\test;

use Exception;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Middleware;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;
use Neighborhoods\YelpFusion\Yelp;

class YelpTest extends TestCase
{
    protected $yelp;
    protected $requestHeaders = [
        'cache-control' => 'no-cache',
    ];

    public function testSearchResponse()
    {
        $yelp = new Yelp(
            $this->getMockHandler(
                new Response(200, [], '{"test": "success"}')
            )
        );
        $response = $yelp->search([], 'BEARER TOKEN');

        $this->assertEquals('object', gettype($response));
        $this->assertEquals('success', $response->test);
    }

    public function testSearchRequest()
    {
        $params = [
            'categories' => 'arts',
            'latitude' => '41.891564',
            'longitude'=> '-87.611906',
        ];
        $requests = [];
        $yelp = new Yelp(
            $this->getMockHandler(
                new Response(200, [], '{"test": "success"}'),
                $requests
            )
        );
        $yelp->search($params, 'BEARER TOKEN');

        $requestHeaders = $requests[0]['request']->getHeaders();
        $requestQuery = $requests[0]['request']->getUri()->getQuery();

        parse_str($requestQuery, $parsedRequestQuery);

        $this->assertEquals(Yelp::HTTP_GET, $requests[0]['request']->getMethod());
        $this->assertEquals($params, $parsedRequestQuery);

        foreach ($this->requestHeaders as $headerKey => $headerValue) {
            $this->assertEquals($headerValue, $requestHeaders[$headerKey][0]);
        }
    }

    public function testSearchThrowsOnCommunicationError()
    {
        $yelp = new Yelp(
            $this->getMockHandler(
                new RequestException('error', new Request('GET', 'test'))
            )
        );

        $this->expectException(Exception::class);

        $yelp->search([], 'BEARER TOKEN');
    }

    public function testSearchThrowsOnNon200Response()
    {
        $yelp = new Yelp(
            $this->getMockHandler(
                new Response(201, [], '{"test": "success"}')
            )
        );

        $this->expectException(Exception::class);

        $yelp->search([], 'BEARER TOKEN');
    }

    public function testSearchThrowsOnNonJSONResponse()
    {
        $yelp = new Yelp(
            $this->getMockHandler(
                new Response(200, [], 'This is not JSON')
            )
        );

        $this->expectException(Exception::class);

        $yelp->search([], 'BEARER TOKEN');
    }

    protected function getMockHandler($response, &$requests = [])
    {
        $history = Middleware::history($requests);
        $handler = new MockHandler([$response]);
        $stack = HandlerStack::create($handler);
        $stack->push($history);

        return $stack;
    }
}
