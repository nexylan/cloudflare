<?php

/*
 * This file is part of the Nexylan CloudFlare package.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\CloudFlare\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class NexyCloudFlareExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $cloudflareOptions = [
            'email' => $config['credentials']['email'],
            'api_key' => $config['credentials']['api_key'],
        ];
        $container->setParameter($this->getAlias().'.options', $cloudflareOptions);

        $loader->load('cloudflare.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'nexy_cloudflare';
    }
}
