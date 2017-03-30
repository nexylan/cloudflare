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

use Nexy\CloudFlare\Api\Zone\Analytics;
use Nexy\CloudFlare\Api\Zone\Settings;
use Nexy\CloudFlare\Api\Zone\Ssl;
use Nexy\CloudFlare\ResultPager;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Zone extends AbstractApi
{
    /**
     * @var Settings
     */
    private $apiSettings = null;

    /**
     * @var Ssl
     */
    private $apiSsl = null;

    /**
     * @var Analytics
     */
    private $apiAnalytics = null;

    /**
     * @param array $parameters
     * @param int   $page
     *
     * @return ResultPager
     */
    public function index(array $parameters = [], $page = 1)
    {
        return $this->getIndex('zones', array_merge($parameters, ['page' => $page]));
    }

    /**
     * @param string $id
     *
     * @return array
     */
    public function show($id)
    {
        return $this->get(sprintf('zones/%s', $id));
    }

    /**
     * @param string $name The domain name
     *
     * @return array
     */
    public function create($name)
    {
        return $this->postJson('zones', ['name' => $name]);
    }

    /**
     * Remove ALL files from CloudFlare's cache.
     *
     * @see https://api.cloudflare.com/#zone-purge-all-files
     *
     * @param string $id
     *
     * @return array
     */
    public function purgeAllFiles($id)
    {
        return $this->deleteJson(sprintf('zones/%s/purge_cache', $id), ['purge_everything' => true]);
    }

    /**
     * @param string $id
     *
     * @return Settings
     */
    public function settings($id)
    {
        if (null === $this->apiSettings) {
            $this->apiSettings = new Settings($this->httpClient);
        }

        $this->apiSettings->setZoneId($id);

        return $this->apiSettings;
    }

    /**
     * @param string $id
     *
     * @return Ssl
     */
    public function ssl($id)
    {
        if (null === $this->apiSsl) {
            $this->apiSsl = new Ssl($this->httpClient);
        }

        $this->apiSsl->setZoneId($id);

        return $this->apiSsl;
    }

    /**
     * @param string $id
     *
     * @return Analytics
     */
    public function analytics($id)
    {
        if (null === $this->apiAnalytics) {
            $this->apiAnalytics = new Analytics($this->httpClient);
        }

        $this->apiAnalytics->setZoneId($id);

        return $this->apiAnalytics;
    }
}
