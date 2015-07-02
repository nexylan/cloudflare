<?php

/*
 * This file is part of the Nexylan CloudFlare package.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\CloudFlare\Api;

use Nexy\CloudFlare\HttpClient\HttpClientInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class AbstractApi implements ApiInterface
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * API per_page option.
     *
     * @var int
     */
    private $perPage = 20;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * {@inheritdoc}
     *
     * @return AbstractApi
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function get($path, array $parameters = [], array $headers = [])
    {
        $response = $this->httpClient->get($path, $parameters, $headers);

        return $this->parseResponseContent($response);
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, $body = null, array $headers = [])
    {
        $response = $this->httpClient->post($path, $body, $headers);

        return $this->parseResponseContent($response);
    }

    /**
     * {@inheritDoc}
     */
    public function patch($path, $body = null, array $headers = [])
    {
        $response = $this->httpClient->patch($path, $body, $headers);

        return $this->parseResponseContent($response);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path, $body = null, array $headers = [])
    {
        $response = $this->httpClient->delete($path, $body, $headers);

        return $this->parseResponseContent($response);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, $body, array $headers = [])
    {
        $response = $this->httpClient->put($path, $body, $headers);

        return $this->parseResponseContent($response);
    }

    private function parseResponseContent($response)
    {
        $content = json_decode($response, true);

        return $content['result'];
    }
}
