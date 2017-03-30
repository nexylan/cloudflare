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
 * @see https://api.cloudflare.com/#responses
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class HttpClientErrorException extends RuntimeException
{
    /**
     * @var string
     */
    private $httpClientMessage;

    /**
     * @var string
     */
    private $httpClientCode;

    /**
     * @var string
     */
    private $cloudFlareMessage;

    /**
     * @var int
     */
    private $cloudFlareCode;

    /**
     * @param string     $httpClientMessage
     * @param int        $httpClientCode
     * @param string     $cloudFlareMessage
     * @param int        $cloudFlareCode
     * @param \Exception $previous
     */
    public function __construct($httpClientMessage = '', $httpClientCode = 0, $cloudFlareMessage = '', $cloudFlareCode = 0, \Exception $previous = null)
    {
        $this->httpClientMessage = $httpClientMessage;
        $this->httpClientCode = $httpClientCode;
        $this->cloudFlareMessage = $cloudFlareMessage;
        $this->cloudFlareCode = $cloudFlareCode;

        $message = $httpClientMessage;
        if ($this->cloudFlareMessage && $this->cloudFlareCode) {
            $message .= sprintf(' / CloudFlare error: %d - %s', $this->cloudFlareCode, $this->cloudFlareMessage);
        }

        parent::__construct($message, $httpClientCode, $previous);
    }

    /**
     * @return string
     */
    public function getHttpClientMessage()
    {
        return $this->httpClientMessage;
    }

    /**
     * @return string
     */
    public function getHttpClientCode()
    {
        return $this->httpClientCode;
    }

    /**
     * @return string
     */
    public function getCloudFlareMessage()
    {
        return $this->cloudFlareMessage;
    }

    /**
     * @return int
     */
    public function getCloudFlareCode()
    {
        return $this->cloudFlareCode;
    }
}
