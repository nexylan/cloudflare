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

use Nexy\CloudFlare\ResultPager;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Zone extends AbstractApi
{
    /**
     * @param int $page
     *
     * @return ResultPager
     */
    public function index($page = 1)
    {
        return $this->getIndex('zones', ['page' => $page]);
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
