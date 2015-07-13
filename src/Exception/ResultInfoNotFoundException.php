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
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class ResultInfoNotFoundException extends ApiErrorException
{
    /**
     * {@inheritdoc}
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        if (empty($message)) {
            $message = 'No result information on this API response.';
        }

        parent::__construct($message, $code, $previous);
    }
}
