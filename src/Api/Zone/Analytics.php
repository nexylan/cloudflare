<?php

/*
 * This file is part of the Nexylan CloudFlare package.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\CloudFlare\Api\Zone;

use Nexy\CloudFlare\Api\AbstractApi;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class Analytics extends AbstractApi
{
    /**
     * @var string
     */
    private $zoneId = null;

    /**
     * @param string $zoneId
     *
     * @return Settings
     */
    public function setZoneId($zoneId)
    {
        $this->zoneId = $zoneId;

        return $this;
    }

    /**
     * @see https://api.cloudflare.com/#zone-analytics-dashboard
     *
     * @param \DateTime $since
     * @param \DateTime $until
     * @param bool      $excludeSeries
     * @param bool      $continuous
     *
     * @return array
     */
    public function dashboard(\DateTime $since = null, \DateTime $until = null, $excludeSeries = false, $continuous = true)
    {
        $parameters = [
            'exclude_series' => $excludeSeries,
            'continuous' => $continuous,
        ];

        if (null !== $since) {
            $now = isset($now) ? $now : new \DateTime('now');
            $parameters = array_merge($parameters, ['since' => -(int) ($now->diff($since)->format('%a')) * 24 * 60]);
        }

        if (null !== $until) {
            $now = isset($now) ? $now : new \DateTime('now');
            $parameters = array_merge($parameters, ['until' => -(int) ($now->diff($until)->format('%a')) * 24 * 60]);
        }

        return $this->get(sprintf('zones/%s/analytics/dashboard', $this->zoneId), $parameters);
    }
}
