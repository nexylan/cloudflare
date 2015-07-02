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

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
interface ApiInterface
{
    /**
     * @return int
     */
    public function getPerPage();

    /**
     * @param int $perPage
     *
     * @return ApiInterface
     */
    public function setPerPage($perPage);

    /**
     * Call GET http client request.
     *
     * @param string $path       Request path
     * @param array  $parameters GET Parameters
     * @param array  $headers    Reconfigure the request headers for this call only
     *
     * @return array
     */
    public function get($path, array $parameters = [], array $headers = []);

    /**
     * Call POST http client request.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return array
     */
    public function post($path, $body = null, array $headers = []);

    /**
     * Call PATCH http client request.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @internal param array $parameters Request body
     *
     * @return array
     */
    public function patch($path, $body = null, array $headers = []);

    /**
     * Call PUT http client request.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return array
     */
    public function put($path, $body, array $headers = []);

    /**
     * Call DELETE http client request.
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return array
     */
    public function delete($path, $body = null, array $headers = []);
}
