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
class AbstractApi implements ApiInterface
{
    /**
     * API per_page option.
     *
     * @var int
     */
    private $perPage = 20;

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
