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

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class Client
{
    const API_BASE_URL = 'https://api.cloudflare.com/client/v4';

    /**
     * @var array
     */
    private $options;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);
    }

    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user_agent'    => 'nexylan-cloudflare-sdk (https://github.com/nexylan/cloudflare)',
            'timeout'       => 10,
        ]);
        $resolver->setAllowedTypes('user_agent', 'string');
        $resolver->setAllowedTypes('timeout', 'int');
    }
}
