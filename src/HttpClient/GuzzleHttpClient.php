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
use GuzzleHttp\Exception\ClientException;
use Nexy\CloudFlare\CloudFlare;
use Nexy\CloudFlare\Exception\HttpClientErrorException;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class GuzzleHttpClient extends AbstractHttpClient
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
        $headers = [
            'User-Agent'    => $options['user_agent'],
            'X-Auth-Key'    => $options['api_key'],
            'X-Auth-Email'  => $options['email'],
        ];

        if (version_compare(Client::VERSION, '6.0') >= 0) {
            $this->client = new Client([
                'base_uri'      => CloudFlare::API_BASE_URL,
                'timeout'       => $options['timeout'],
                'headers'       => $headers,
            ]);
        } else {
            $this->client = new Client([
                'base_url'      => CloudFlare::API_BASE_URL,
                'timeout'       => $options['timeout'],
                'defaults'      => [
                    'headers'       => $headers,
                ],
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function request($path, $method = 'GET', $body = null, array $parameters = null, array $headers = [])
    {
        try {
            // Guzzle <6.0 BC
            if (version_compare(Client::VERSION, '6.0') >= 0) {
                $response = $this->client->request($method, $path, [
                    'body'      => $body,
                    'query'     => $parameters,
                    'headers'   => $headers,
                ]);
            } else {
                $request = $this->client->createRequest($method, $path, [
                    'body'      => $body,
                    'query'     => $parameters,
                    'headers'   => $headers,
                ]);

                $response = $this->client->send($request);
            }
        } catch (ClientException $e) {
            $cloudFlareError = json_decode($e->getResponse()->getBody()->getContents(), true)['errors'][0];
            throw new HttpClientErrorException($e->getMessage(), $e->getCode(), $cloudFlareError['message'], $cloudFlareError['code']);
        }

        return $response->getBody();
    }
}
