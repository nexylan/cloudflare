<?php

/*
 * This file is part of the Nexylan CloudFlare package.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\CloudFlare\HttpClient;

use GuzzleHttp\Client;
use Nexy\CloudFlare\CloudFlare;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * {@inheritdoc}
     */
    public function init(array $options)
    {
        $this->client = new Client([
            'base_uri'      => CloudFlare::API_BASE_URL,
            'timeout'       => $options['timeout'],
            'headers'       => [
                'User-Agent'    => $options['user_agent'],
                'X-Auth-Key'    => $options['api_key'],
                'X-Auth-Email'  => $options['email'],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function request($path, $body = null, $method = 'GET', array $headers = [])
    {
        $response = $this->client->request($method, $path, [
            'body'      => $body,
            'headers'   => $headers,
        ]);

        return json_decode($response->getBody(), true);
    }
}
