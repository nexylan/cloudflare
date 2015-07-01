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
     * Init and setup http client with CloudFlare SDK options.
     *
     * @param array $options
     */
    public function init(array $options);

    /**
     * Send a request to the server, receive a response,
     * decode the response and returns an associative array.
     *
     * @param string   $path       Request path
     * @param string[] $body       Request body. Array converted to JSON payload. See sample https://api.cloudflare.com/#user-update-user
     * @param string   $httpMethod HTTP method to use
     * @param array    $headers    Request headers
     *
     * @return array The associative array response content
     */
    public function request($path, $body = null, $httpMethod = 'GET', array $headers = []);
}
