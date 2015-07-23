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

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
interface HttpClientInterface
{
    /**
     * Init and setup http cloudflare with CloudFlare SDK options.
     *
     * @param array $options
     */
    public function init(array $options);

    /**
     * Send a request to the server, receive a response,
     * decode the response and returns an associative array.
     *
     * @param string   $path       Request path
     * @param string   $httpMethod HTTP method to use
     * @param string   $body       Request body.
     * @param string[] $parameters Request GET parameters
     * @param array    $headers    Request headers
     *
     * @return string The response content
     */
    public function request($path, $httpMethod = 'GET', $body = null, array $parameters = null, array $headers = []);

    /**
     * Send a GET request.
     *
     * @param string $path       Request path
     * @param array  $parameters GET Parameters
     * @param array  $headers    Reconfigure the request headers for this call only
     *
     * @return string The response content
     */
    public function get($path, array $parameters = [], array $headers = []);

    /**
     * Send a POST request.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return string The response content
     */
    public function post($path, $body = null, array $headers = []);

    /**
     * Send a PATCH request.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return string The response content
     */
    public function patch($path, $body = null, array $headers = []);

    /**
     * Send a PUT request.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return string The response content
     */
    public function put($path, $body, array $headers = []);

    /**
     * Send a DELETE request.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return string The response content
     */
    public function delete($path, $body = null, array $headers = []);
}
