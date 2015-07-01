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
    protected $httpClient;

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
}
