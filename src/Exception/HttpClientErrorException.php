<?php

/*
 * This file is part of the Nexylan CloudFlare package.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\CloudFlare\Exception;

/**
 * Thrown when API response HTTP code is an error.
 *
 * @link https://api.cloudflare.com/#responses
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class HttpClientErrorException extends RuntimeException
{
}
