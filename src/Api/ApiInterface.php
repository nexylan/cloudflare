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
     * @return $this
     */
    public function setPerPage($perPage);
}
