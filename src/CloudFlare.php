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

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Nexy\CloudFlare\Api\ApiInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method Api\Zone apiZone()
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class CloudFlare
{
    const API_BASE_URL = 'https://api.cloudflare.com/client/v4';

    /**
     * @var HttpMethodsClient
     */
    private $httpClient;

    /**
     * API instances.
     *
     * Instances are added on this array on each `api` method request.
     * Those instances can be reused with options keeping (like pagination).
     *
     * @var ApiInterface[]
     */
    private $apis = [];

    /**
     * @param array      $options
     * @param HttpClient $httpClient
     */
    public function __construct(array $options = [], HttpClient $httpClient = null)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $options = $resolver->resolve($options);

        $pluginClient = new PluginClient($httpClient ?: HttpClientDiscovery::find(), [
            new BaseUriPlugin(UriFactoryDiscovery::find()->createUri(self::API_BASE_URL)),
            new HeaderDefaultsPlugin([
                'User-Agent' => $options['user_agent'],
                'X-Auth-Key' => $options['api_key'],
                'X-Auth-Email' => $options['email'],
            ]),
        ]);
        $this->httpClient = new HttpMethodsClient($pluginClient, MessageFactoryDiscovery::find());
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return ApiInterface
     */
    public function __call($name, $arguments)
    {
        try {
            return $this->api(str_replace('api', '', $name));
        } catch (\InvalidArgumentException $e) {
            throw new \BadMethodCallException(sprintf('Undefined method %s', $name));
        }
    }

    /**
     * @param string $apiClass
     *
     * @return ApiInterface
     */
    private function api($apiClass)
    {
        if (!isset($this->apis[$apiClass])) {
            $apiFQNClass = '\\Nexy\\CloudFlare\\Api\\'.$apiClass;

            if (false === class_exists($apiFQNClass)) {
                throw new \InvalidArgumentException(sprintf('Undefined api class %s', $apiClass));
            }

            $this->apis[$apiClass] = new $apiFQNClass($this->httpClient);
        }

        return $this->apis[$apiClass];
    }

    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user_agent' => 'nexylan-cloudflare-sdk (https://github.com/nexylan/cloudflare)',
        ]);
        $resolver->setRequired([
            'email',
            'api_key',
        ]);
        $resolver->setAllowedTypes('user_agent', 'string');
        $resolver->setAllowedTypes('email', 'string');
        $resolver->setAllowedTypes('api_key', 'string');
    }
}
