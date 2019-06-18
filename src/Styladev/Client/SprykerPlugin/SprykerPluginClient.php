<?php

namespace Styladev\Client\SprykerPlugin;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Styladev\Client\SprykerPlugin\SprykerPluginFactory getFactory()
 */
class SprykerPluginClient extends AbstractClient implements SprykerPluginClientInterface
{
    protected const STYLA_SEO_API_TTL = 3600;

    /**
     * @api
     *
     * @param string $key
     *
     * @return Object
     */
    public function getSeoData(string $key): Object
    {
        $storageKey = $this->buildStorageKey($key);

        $cachedSeoData = $this->fetchFromStorage($storageKey);
        if ($cachedSeoData) {
            return $cachedSeoData;
        }

        $seoData = $this->getFactory()->getSeoApi()->getSeoData($key);
        $ttl = isset($seoData->expire) ? $seoData->expire : static::STYLA_SEO_API_TTL;
        $this->persistToStorage($storageKey, $seoData, $ttl);

        return $seoData;
    }

    /**
     * @api
     *
     * @param string $key
     *
     * @return Object
     */
    private function fetchFromStorage($key): ?Object {
        $data = $this->getFactory()->getStorageClient()->get($key);
        if (isset($data)) {
            return (object) json_decode(json_encode($data), FALSE);
        }

        return null;
    }

    /**
     * @param string $key
     * @param Object $data
     * @param int $ttl
     */
    private function persistToStorage($key, $data, $ttl): void {
        $lifetime = isset($ttl) ? $ttl : static::STYLA_SEO_API_TTL;
        $encodedData = isset($data) ? json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG) : null;
        $this->getFactory()->getStorageClient()->set($key, $encodedData, $lifetime);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function buildStorageKey($key): string {
        return $this->getCurrentLocale() . '-' . $key;
    }

    /**
     * @return string
     */
    protected function getCurrentLocale()
    {
        return $this->getFactory()->getStore()->getCurrentLocale();
    }
}
