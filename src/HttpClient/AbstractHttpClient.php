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
abstract class AbstractHttpClient implements HttpClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($path, array $parameters = [], array $headers = [])
    {
        // Convert some PHP value to CloudFlare API compliant parameters
        array_walk_recursive($parameters, function (&$item, $key) {
            if (is_bool($item)) {
                $item = true === $item ? 'true' : 'false';
            }
        });

        return $this->request($path, 'GET', null, $parameters, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, $body = null, array $headers = [])
    {
        return $this->request($path, 'POST', $body, null, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($path, $body = null, array $headers = [])
    {
        return $this->request($path, 'PATCH', $body, null, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path, $body = null, array $headers = [])
    {
        return $this->request($path, 'DELETE', $body, null, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function put($path, $body, array $headers = [])
    {
        return $this->request($path, 'PUT', $body, null, $headers);
    }
}
