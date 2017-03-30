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

use Nexy\CloudFlare\Exception\ApiErrorException;
use Nexy\CloudFlare\Exception\ResultInfoNotFoundException;
use Nexy\CloudFlare\HttpClient\HttpClientInterface;
use Nexy\CloudFlare\ResultPager;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class AbstractApi implements ApiInterface
{
    /**
     * API per_page option.
     *
     * @var int
     */
    private $perPage = 20;

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

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
     */
    public function setPerPage($perPage)
    {
        $this->perPage = (null === $perPage ? $perPage : (int) $perPage);

        return $this;
    }

    /**
     * Call GET http client request for index api.
     *
     * This will return the result and the pagination information.
     *
     * @param string $path       Request path
     * @param array  $parameters GET Parameters
     * @param array  $headers    Reconfigure the request headers for this call only
     *
     * @return ResultPager Traversable array of results with pagination information
     */
    protected function getIndex($path, array $parameters = [], array $headers = [])
    {
        if (null !== $this->perPage && !isset($parameters['per_page'])) {
            $parameters['per_page'] = $this->perPage;
        }

        $response = $this->httpClient->get($path, $parameters, $headers);

        return new ResultPager([
            'result' => $this->parseResponseContent($response),
            'info' => $this->parseResponseResultInfo($response),
        ]);
    }

    /**
     * Call GET http client request.
     *
     * @param string $path       Request path
     * @param array  $parameters GET Parameters
     * @param array  $headers    Reconfigure the request headers for this call only
     *
     * @return array
     */
    protected function get($path, array $parameters = [], array $headers = [])
    {
        $response = $this->httpClient->get($path, $parameters, $headers);

        return $this->parseResponseContent($response);
    }

    /**
     * Call POST http client request.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return array
     */
    protected function post($path, $body = null, array $headers = [])
    {
        $response = $this->httpClient->post($path, $body, $headers);

        return $this->parseResponseContent($response);
    }

    /**
     * Call POST with a json converted body.
     *
     * @param string $path
     * @param array  $body    Body content as an array
     * @param array  $headers
     *
     * @return array
     */
    protected function postJson($path, array $body, array $headers = [])
    {
        $jsonBody = json_encode($body);

        return $this->post($path, $jsonBody, $headers);
    }

    /**
     * Call PATCH http client request.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return array
     */
    protected function patch($path, $body = null, array $headers = [])
    {
        $response = $this->httpClient->patch($path, $body, $headers);

        return $this->parseResponseContent($response);
    }

    /**
     * Call PATCH with a json converted body.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return array
     */
    protected function patchJson($path, $body = null, array $headers = [])
    {
        $jsonBody = json_encode($body);

        return $this->patch($path, $jsonBody, $headers);
    }

    /**
     * Call PUT http client request.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return array
     */
    protected function put($path, $body, array $headers = [])
    {
        $response = $this->httpClient->put($path, $body, $headers);

        return $this->parseResponseContent($response);
    }

    /**
     * Call DELETE http client request.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return array
     */
    protected function delete($path, $body = null, array $headers = [])
    {
        $response = $this->httpClient->delete($path, $body, $headers);

        return $this->parseResponseContent($response);
    }

    /**
     * Call DELETE with a json converted body.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return array
     */
    protected function deleteJson($path, $body = null, array $headers = [])
    {
        $jsonBody = json_encode($body);

        return $this->delete($path, $jsonBody, $headers);
    }

    private function parseResponseContent($response)
    {
        $content = json_decode($response, true);

        if (true !== $content['success']) {
            $firstError = $content['errors'][0];

            throw new ApiErrorException($firstError['message'], $firstError['code']);
        }

        return $content['result'];
    }

    private function parseResponseResultInfo($response)
    {
        $content = json_decode($response, true);

        if (!isset($content['result_info'])) {
            throw new ResultInfoNotFoundException();
        }

        return $content['result_info'];
    }
}
