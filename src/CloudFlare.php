<?php

/*
 * This file is part of the Nexylan CloudFlare package.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\CloudFlare;

use Nexy\CloudFlare\HttpClient\GuzzleHttpClient;
use Nexy\CloudFlare\HttpClient\HttpClientInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class CloudFlare
{
    const API_BASE_URL = 'https://api.cloudflare.com/client/v4/';

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var array
     */
    private $options;

    /**
     * @param array               $options
     * @param HttpClientInterface $httpClient
     */
    public function __construct(array $options = [], HttpClientInterface $httpClient = null)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);

        $this->httpClient = $httpClient ? $httpClient : new GuzzleHttpClient($this->options);
    }

    /**
     * @param string $path
     * @param string $body
     * @param string $httpMethod
     *
     * TODO: Remove it. For development and tests
     */
    public function request($path, $body = null, $httpMethod = 'GET')
    {
        var_dump($this->httpClient->request($path, $body, $httpMethod));
    }

    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user_agent'    => 'nexylan-cloudflare-sdk (https://github.com/nexylan/cloudflare)',
            'timeout'       => 10,
        ]);
        $resolver->setRequired([
            'email',
            'api_key',
        ]);
        $resolver->setAllowedTypes('user_agent', 'string');
        $resolver->setAllowedTypes('timeout', 'int');
        $resolver->setAllowedTypes('email', 'string');
        $resolver->setAllowedTypes('api_key', 'string');
    }
}