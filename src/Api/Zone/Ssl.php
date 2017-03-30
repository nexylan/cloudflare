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

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Ssl extends AbstractZoneApi
{
    /**
     * @see https://api.cloudflare.com/#ssl-verification-get-ssl-verification
     *
     * @return array
     */
    public function verification()
    {
        // Returns the first and unique element of the array.
        return $this->get(sprintf('zones/%s/ssl/verification', $this->getZoneId()))[0];
    }
}
