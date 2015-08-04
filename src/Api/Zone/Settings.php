<?php

/*
 * This file is part of the Nexylan CloudFlare package.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\CloudFlare\Api\Zone;

use Doctrine\Common\Inflector\Inflector;
use Nexy\CloudFlare\Api\AbstractApi;

/**
 * @method mixed getAdvancedDdos
 * @method mixed getAlwaysOnline
 * @method mixed getBrowserCacheTtl
 * @method mixed getBrowserCheck
 * @method mixed getCacheLevel
 * @method mixed getChallengeTtl
 * @method mixed getDevelopmentMode
 * @method mixed getEdgeCacheTtl
 * @method mixed getEmailObfuscation
 * @method mixed getHotlinkProtection
 * @method mixed getIpGeolocation
 * @method mixed getIpv6
 * @method mixed getMaxUpload
 * @method mixed getMinify
 * @method mixed getMirage
 * @method mixed getMobileRedirect
 * @method mixed getOriginErrorPagePassThru
 * @method mixed getPolish
 * @method mixed getPrefetchPreload
 * @method mixed getPseudoIpv4
 * @method mixed getResponseBuffering
 * @method mixed getRocketLoader
 * @method mixed getSecurityHeader
 * @method mixed getSecurityLevel
 * @method mixed getServerSideExclude
 * @method mixed getSortQueryStringForCache
 * @method mixed getSsl
 * @method mixed getTls12Only
 * @method mixed getTlsClientAuth
 * @method mixed getTrueClientIpHeader
 * @method mixed getWaf
 * @method mixed setAdvancedDdos setAdvancedDdos(mixed $value)
 * @method mixed setAlwaysOnline setAlwaysOnline(mixed $value)
 * @method mixed setBrowserCacheTtl setBrowserCacheTtl(mixed $value)
 * @method mixed setBrowserCheck setBrowserCheck(mixed $value)
 * @method mixed setCacheLevel setCacheLevel(mixed $value)
 * @method mixed setChallensettl setChallensettl(mixed $value)
 * @method mixed setDevelopmentMode setDevelopmentMode(mixed $value)
 * @method mixed setEdgeCacheTtl setEdgeCacheTtl(mixed $value)
 * @method mixed setEmailObfuscation setEmailObfuscation(mixed $value)
 * @method mixed setHotlinkProtection setHotlinkProtection(mixed $value)
 * @method mixed setIpGeolocation setIpGeolocation(mixed $value)
 * @method mixed setIpv6 setIpv6(mixed $value)
 * @method mixed setMaxUpload setMaxUpload(mixed $value)
 * @method mixed setMinify setMinify(mixed $value)
 * @method mixed setMirage setMirage(mixed $value)
 * @method mixed setMobileRedirect setMobileRedirect(mixed $value)
 * @method mixed setOriginErrorPagePassThru setOriginErrorPagePassThru(mixed $value)
 * @method mixed setPolish setPolish(mixed $value)
 * @method mixed setPrefetchPreload setPrefetchPreload(mixed $value)
 * @method mixed setPseudoIpv4 setPseudoIpv4(mixed $value)
 * @method mixed setResponseBuffering setResponseBuffering(mixed $value)
 * @method mixed setRocketLoader setRocketLoader(mixed $value)
 * @method mixed setSecurityHeader setSecurityHeader(mixed $value)
 * @method mixed setSecurityLevel setSecurityLevel(mixed $value)
 * @method mixed setServerSideExclude setServerSideExclude(mixed $value)
 * @method mixed setSortQueryStringForCache setSortQueryStringForCache(mixed $value)
 * @method mixed setSsl setSsl(mixed $value)
 * @method mixed setTls12Only setTls12Only(mixed $value)
 * @method mixed setTlsClientAuth setTlsClientAuth(mixed $value)
 * @method mixed setTrueClientIpHeader setTrueClientIpHeader(mixed $value)
 * @method mixed setWaf setWaf(mixed $value)
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Settings extends AbstractApi
{
    const AVAILABLE_PROPERTIES = [
        'advanced_ddos',
        'always_online',
        'browser_cache_ttl',
        'browser_check',
        'cache_level',
        'challenge_ttl',
        'development_mode',
        'edge_cache_ttl',
        'email_obfuscation',
        'hotlink_protection',
        'ip_geolocation',
        'ipv6',
        'max_upload',
        'minify',
        'mirage',
        'mobile_redirect',
        'origin_error_page_pass_thru',
        'polish',
        'prefetch_preload',
        'pseudo_ipv4',
        'response_buffering',
        'rocket_loader',
        'security_header',
        'security_level',
        'server_side_exclude',
        'sort_query_string_for_cache',
        'ssl',
        'tls_1_2_only',
        'tls_client_auth',
        'true_client_ip_header',
        'waf',
    ];

    /**
     * @var string
     */
    private $zoneId = null;

    /**
     * @param string $zoneId
     *
     * @return Settings
     */
    public function setZoneId($zoneId)
    {
        $this->zoneId = $zoneId;

        return $this;
    }

    /**
     * Get all zone settings.
     *
     * @link https://api.cloudflare.com/#zone-settings-get-all-zone-settings
     *
     * @return array Associative array with id => value architecture
     */
    public function index()
    {
        $settings = $this->get(sprintf('zones/%s/settings', $this->zoneId));
        $formattedSettings = [];

        foreach ($settings as $settingsItem) {
            $formattedSettings[$settingsItem['id']] = $this->toSdkSettingsValue($settingsItem['value']);
        }

        return $formattedSettings;
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return array
     */
    public function __call($name, $arguments)
    {
        if (false === strpos($name, 'get') && false === strpos($name, 'set')) {
            throw new \BadMethodCallException(sprintf('Undefined method %s', $name));
        }

        $property = Inflector::tableize(str_replace(['get', 'set'], '', $name));

        if (!in_array($property, self::AVAILABLE_PROPERTIES, true)) {
            throw new \BadMethodCallException(sprintf('Undefined method %s', $name));
        }

        $path = sprintf('zones/%s/settings/%s', $this->zoneId, $property);
        if (false !== strpos($name, 'set')) {
            $response = $this->patchJson($path, ['value' => $this->toCloudFlareSettingsValue($arguments[0])]);

            return $this->toSdkSettingsValue($response['value']);
        }

        return $this->toSdkSettingsValue($this->get($path)['value']);
    }

    private function toSdkSettingsValue($value)
    {
        // Transform on/off to boolean
        if (is_string($value) && in_array($value, ['on', 'off'], true)) {
            $value = $value === 'on' ? true : false;
        }

        return $value;
    }

    private function toCloudFlareSettingsValue($value)
    {
        // Transform boolean on/off
        if (is_bool($value)) {
            $value = $value === true ? 'on' : 'off';
        }

        return $value;
    }
}
