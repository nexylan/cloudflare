<?php

/*
 * This file is part of the Nexylan CloudFlare package.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\CloudFlare\Tests;

use Nexy\CloudFlare\Client;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testValidOptions()
    {
        $client = new Client([
            'email'     => 'foo@bar.com',
            'api_key'   => 'MySecretApiKey',
        ]);

        $this->assertAttributeEquals([
            'user_agent'    => 'nexylan-cloudflare-sdk (https://github.com/nexylan/cloudflare)',
            'timeout'       => 10,
            'email'         => 'foo@bar.com',
            'api_key'       => 'MySecretApiKey',
        ], 'options', $client);
    }

    public function testOverrideDefaultOptions()
    {
        $client = new Client([
            'email'         => 'foo@bar.com',
            'api_key'       => 'MySecretApiKey',
            'user_agent'    => 'My awesome user agent',
            'timeout'       => 5,
        ]);

        $this->assertAttributeEquals([
            'user_agent'    => 'My awesome user agent',
            'timeout'       => 5,
            'email'         => 'foo@bar.com',
            'api_key'       => 'MySecretApiKey',
        ], 'options', $client);
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function testMissingEmailOption()
    {
        new Client([
            'api_key'   => 'MySecretApiKey',
        ]);
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function testMissingApiKeyOption()
    {
        new Client([
            'email'     => 'foo@bar.com',
        ]);
    }
}
