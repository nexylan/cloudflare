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
class Zone extends AbstractApi
{
    /**
     * @return array
     */
    public function index()
    {
        return $this->get('zones');
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
}
