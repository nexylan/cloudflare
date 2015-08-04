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

use Nexy\CloudFlare\Api\Zone\Settings;
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
}
