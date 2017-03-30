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
abstract class AbstractZoneApi extends AbstractApi
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
    final public function setZoneId($zoneId)
    {
        $this->zoneId = $zoneId;

        return $this;
    }

    /**
     * @return string
     */
    final public function getZoneId()
    {
        return $this->zoneId;
    }
}
